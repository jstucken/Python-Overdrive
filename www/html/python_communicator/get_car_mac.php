<?php

/*
* This script is called by Python scripts (Overdrive.py) to obtain
* the Mac address for a given car_id
*
* This script checks the database and returns appropriate response
*
* Author: jstucken 15-6-2021
*/
require_once('/home/pi/Python-Overdrive/www/html/includes/site_config.php');

//dbug($_POST,'$_POST');
//dbug($_SERVER,'$_SERVER');


// check user has supplied a car_id
$car_id = $_POST['car_id'];
//dbug($_POST,'$_POST');

if (empty($car_id)) {
     die("ERROR - get_car_mac.php could not obtain the car_id from POST which is supposed to be passed from Python.");
}

// find Mac address of the supplied car from the DB
$car_id = db::makeDBSafe($car_id);

$select_sql = "SELECT * FROM cars WHERE car_id='$car_id'";
$select_result = $db->getRow($select_sql);
if (empty($select_result)) {
    die("ERROR - could not obtain the Mac address of car_id: ($car_id). Are you sure this car has been added to the database through the teacher GUI?");
}

// all good if they get to here, echo out the Mac address to Python
$mac_address = $select_result['mac_address'];

echo $mac_address;

?>