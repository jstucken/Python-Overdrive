<?php
// this scripts saves a car mac address from a bluetooth scan into the DB

require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/site_config.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/smarty_config.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php');

//dbug($_POST,'$_POST');
//exit;
$key = $_POST['key'];

if (!is_numeric($key)) {
	trigger_error('Error - $key must be numeric', E_USER_ERROR);
}

// get the car_mac and car_type from posted data
$car_mac = $_POST['car_mac'][$key];
$car_type = $_POST['car_type'][$key];
$description = $_POST['description'][$key];

// ensure user has specified what car type they wish to add
if (empty($car_type)) {
	$message = "Error - Please select the car type to add.";
	setStatusMessage($message, true);
	loadPage("/cars.php");
}

//dbug($car_mac,'car_mac');
//dbug($car_type,'car_type');

// sanitise user input
$car_mac = db::makeDBSafe($car_mac);
$car_type = db::makeDBSafe($car_type);
$description = db::makeDBSafe($description);
//dbug($date_time,'date_time');

$insert_sql = "INSERT INTO cars (mac_address, type, description) VALUES ('$car_mac', '$car_type', '$description')";

$insert_result = db::doQuery($insert_sql);
if ($insert_result) {
	$car_id = db::getLastID();
	
	$message = "New $car_type added with car_id $car_id";
	setStatusMessage($message, false);
	loadPage("/cars.php");
}
else {
	trigger_error('Error - could not insert new record into cars table. $insert_sql: '.$insert_sql, E_USER_ERROR);
}
?>