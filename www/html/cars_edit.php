<?php
// this scripts saves a car mac address from a bluetooth scan into the DB

require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/site_config.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/smarty_config.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php');

//dbug($_GET,'$_GET');

// if user has clicked saved on edit page, save new data
if ($_POST) {
	
	//dbug($_POST,'$_POST');
	//dbug($_SESSION,'$_SESSION');
	
	//exit;
	// car_id passed through session
	$car_id = $_SESSION['car_edit_id'];
	
	if (!is_numeric($car_id) OR empty($car_id)) {
		trigger_error('Error - $car_id from session must be numeric and cannot be empty', E_USER_ERROR);
	}
	
	// sanitise user input
	$car_type = $_POST['car_type'];
	$description = $_POST['description'];
	
	$car_type = db::makeDBSafe($car_type);
	$description = db::makeDBSafe($description);
	
	if (empty($car_type)) {
		trigger_error('Error - $car_type cannot be empty', E_USER_ERROR);
	}
	
	// update database with new user data
	$update_sql = "UPDATE cars SET type = '$car_type', description = '$description', modified = NOW() WHERE car_id = '$car_id' LIMIT 1";
	
	//dbug($update_sql,'update_sql');

	if (!$result = $db->doQuery($update_sql))
	{
		trigger_error('Error - Could not update cars table. $update_sql: '.$update_sql, E_USER_ERROR);
	}
	
	$message = "Success - car_id $car_id has been updated.";
	setStatusMessage($message, false);
	loadPage("/cars.php");
	
}
else {
	// else they just opened this page, show form
	$car_id = $_GET['car_id'];

	if (!is_numeric($car_id) OR $car_id < 0) {
		$message = "Error - car_id must be numeric";
		setStatusMessage($message, true);
		loadPage("/cars.php");
	}
	
	// save id to session
	$_SESSION['car_edit_id'] = $car_id;
	
	// sanitise the id
	$car_id = db::makeDBSafe($car_id);
	
	// get the car data from DB
	$select_sql = "SELECT * FROM cars WHERE car_id='$car_id'";
	$car_data = $db->getRow($select_sql);
	
	if (!$car_data) {
		trigger_error('Error - could not find car in DB. $select_sql: '.$select_sql, E_USER_ERROR);
	}
	
	//dbug($car_data,'$car_data');
}
	
/*	
$message = "car_id $car_id deleted";
setStatusMessage($message, false);
loadPage("/cars.php");
*/

$smarty->assign('car_data', $car_data);
$smarty->assign('template', getPageTemplate());
$smarty->display('default.tpl');
?>