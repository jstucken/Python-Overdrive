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


// check user has supplied a car_id
$mac_address = $_POST['mac_address'];
//dbug($_POST,'$_POST');

if (empty($mac_address)) {
     die("ERROR - get_car_id.php could not obtain the mac_address from POST which is supposed to be passed from Python.");
}

// find Mac address of the supplied car from the DB
$mac_address = db::makeDBSafe($mac_address);

$select_sql = "SELECT car_id FROM cars WHERE mac_address='$mac_address'";
$select_result = $db->getRow($select_sql);
if (empty($select_result)) {
    die("ERROR - could not obtain the car_id address of Mac address: ($mac_address). Please ensure that this car has been added correctly to the database through the teacher GUI.");
}

// all good if they get to here, echo out the Mac address to Python
$car_id = $select_result['car_id'];

echo $car_id;

?>