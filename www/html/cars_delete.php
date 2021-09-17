<?php
// this scripts saves a car mac address from a bluetooth scan into the DB

require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/site_config.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/smarty_config.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php');

//dbug($_GET,'$_GET');

$car_id = $_GET['car_id'];

if (!is_numeric($car_id) OR $car_id < 0) {
	$message = "Error - car_id must be numeric";
	setStatusMessage($message, true);
	loadPage("/cars.php");
}

// sanitise user input
$car_id = db::makeDBSafe($car_id);

// delete the car from the database
$delete_sql = "DELETE FROM cars WHERE car_id='$car_id' LIMIT 1";

//dbug($delete_sql,'delete_sql');

$delete_result = db::doQuery($delete_sql);
if (!$delete_result) {
	trigger_error('Error - could not delete car from cars. $delete_sql: '.$delete_sql, E_USER_ERROR);
}

// unassign this car from every student
$assigned_cars_delete_sql = "DELETE FROM students_cars WHERE car_id='$car_id'";

$assigned_cars_delete_result = db::doQuery($assigned_cars_delete_sql);
if (!$assigned_cars_delete_result) {
	trigger_error('Error - could not delete assigned cars from students_cars table. $assigned_cars_delete_sql: '.$assigned_cars_delete_sql, E_USER_ERROR);
}
	
$message = "car_id $car_id deleted";
setStatusMessage($message, false);
loadPage("/cars.php");
?>