<?php

/*
* This script is called by Python scripts (Overdrive.py) to obtain
* the car_id address for a given car Mac Address
*
* This script checks the database and returns appropriate response
*
* Author: jstucken 20-6-2021
*/
require_once('/home/pi/DET-Python-Anki-Overdrive/www/html/includes/site_config.php');

//dbug($_POST,'$_POST');
//dbug($_SERVER,'$_SERVER');


// username is automatically posted with Python data
$username = $_POST['user'];

// If it is pi user running this script
// return a 999999 figure 
if ($username == 'pi') {
    echo '999999';
    exit;
}

// find Mac address of the supplied car from the DB
$username = db::makeDBSafe($username);

$select_sql = "SELECT student_id FROM students WHERE username='$username'";
$select_result = $db->getRow($select_sql);
if (empty($select_result)) {
    die("ERROR - could not obtain the student_id for username: $username. Please ensure that this student has been added correctly to the database through the teacher GUI.");
}

// all good if they get to here, echo out the Mac address to Python
$student_id = $select_result['student_id'];

echo $student_id;

?>