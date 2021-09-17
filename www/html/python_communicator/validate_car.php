<?php

/*
* This script is called by Python scripts (Overdrive.py) to check whether a student should have
* access to a particular car or not.
*
* This script checks the database and returns appropriate response
*
* Author: jstucken 14-6-2021
*/
require_once('/home/pi/Python-Overdrive/www/html/includes/site_config.php');

//dbug($_POST,'$_POST');
//dbug($_SERVER,'$_SERVER');


// check user has supplied a car_id
$car_id = $_POST['car_id'];

if (empty($car_id)) {
     die("ERROR - PHP could not obtain the car_id from POST which is supposed to be passed from Python.");
}

$car_mac = '';

// has user supplied a car_id or Mac address?
if (is_numeric($car_id)) {
    // looks like a car_id, fetch this car's Mac address
    
    $mac_sql = "SELECT * FROM cars WHERE car_id='$car_id'";
    //dbug($mac_sql,'mac_sql');

    $mac_result = $db->getRow($mac_sql);
    if (empty($mac_result)) {
        echo "ERROR - COULD NOT FIND A CAR IN THE DATABASE WITH THAT car_id ($car_id). Please ensure it has been added correctly using the teacher GUI";
        exit;
    }
    
    // all ok, we've found the car's mac address
    $car_mac = $mac_result['mac_address'];
}  
else {
    // looks like user has supplied a mac address.
    // find the corresponding car_id for this mac address
    
    $mac_sql = "SELECT * FROM cars WHERE mac_address='$car_id'";
    //dbug($mac_sql,'mac_sql');
    
    $mac_result = $db->getRow($mac_sql);
    
    if (empty($mac_result)) {
        echo "ERROR - COULD NOT FIND A CAR IN THE DATABASE WITH THAT MAC ADDRESS ($car_id). Please check that it has been added using the teacher GUI.";
        exit;
    }
    
    // use the found car_id
    $car_mac = $car_id;
    $car_id = $mac_result['car_id'];
}

// all ok so far if they get to here, continue...
//echo "car_id set to: $car_id and car_mac: $car_mac";
// grab students username from $POST
$username = $_POST['user'];

if (empty($username)) {
    die("ERROR - PHP could not obtain the username of the person calling validate_car.php");
}

// if running as Pi user, skip all further checks and return the mac address now
// as user must be a teacher to be running scripts as pi user
if ($username == 'pi') {
    echo $car_mac;
    exit;
}

// otherwise, assume a normal student
// try find student in the database
$username = db::makeDBSafe($username);
$car_id = db::makeDBSafe($car_id);


$select_sql = "SELECT * FROM students WHERE username='$username'";
$select_result = $db->getRow($select_sql);
if (empty($select_result)) {
    die("ERROR - PHP could not obtain the username of the person calling validate_car.php (username set to: $username)");
}

//dbug($select_result,'select_result');
$student_id = $select_result['student_id'];
$class_id = $select_result['class_id'];

//echo "student_id: $student_id";
//echo "class_id: $class_id";

// student must be found successfully, continue


//echo "THE CAR ID IS NOW: $car_id";

// search via car_id
// check if car_id is linked to student
// also ensure they are assigned to an active class
$car_sql = "
SELECT
    sc.*,
    c.class_id as class_id,
    c.active as class_active
FROM students_cars sc
LEFT JOIN classes c ON (c.class_id = '$class_id')
WHERE sc.student_id = '$student_id'
AND sc.car_id = '$car_id'
";

//dbug($car_sql,'$car_sql');
$car_result = $db->getRow($car_sql);

//dbug($car_result,'$car_result');

if (empty($car_result)) {
    // could not find car matching to student, return fail
    echo "ERROR - STUDENT (student_id: $student_id) HAS NOT BEEN ASSIGNED TO THIS CAR (car_id: $car_id)";
    exit;
}
else if (empty($car_result['class_id'])) {
    echo "ERROR - STUDENT (student_id: $student_id) IS NOT ASSIGNED TO A CLASS";
    exit;
}
else if (empty($car_result['class_active']) OR $car_result['class_active'] == '0') {
    echo "ERROR - STUDENT (student_id: $student_id) HAS BEEN ASSIGNED TO AN INACTIVE CLASS (class_id: $class_id)";
    exit;
}
else if ($car_result['class_active'] == '1') {
    // we've found a car assigned to this student. 
    // is the student assigned to an active class
    //echo "STUDENT IS ASSIGNED TO A CAR AND AN ACTIVE CLASS!";
    // return success!
    echo $car_mac;
    exit;
}
else {
    // default catchall fail
    //echo "DEFAULT CATCHALL FAIL";
    echo "ERROR - STUDENT CAR VALIDATION FAILED FOR UNKNOWN REASON (student_id: $student_id)";
    exit;
}
?>