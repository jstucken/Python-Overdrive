<?php
require_once ('includes/site_config.php');
require_once ('includes/smarty_config.php');
require_once ('includes/header.php');

// if user has submitted form
if ($_POST) {
	
	//dbug($_POST,'$_POST');
	
	// sanitise user input
	$student_id = db::makeDBSafe($_POST['student_id']);
	$car_id = db::makeDBSafe($_POST['car_id']);
	$username = 'Manual web app user';
	$speed = db::makeDBSafe($_POST['speed']);
	$car_type = db::makeDBSafe($_POST['car_type']);
	$custom_field1 = db::makeDBSafe($_POST['custom_field1']);
	$custom_field2 = db::makeDBSafe($_POST['custom_field2']);
	$custom_field3 = db::makeDBSafe($_POST['custom_field3']);

	// get current timestamp
	// needs to be in format like: 2021-02-10 04:13:15
	$date_time = date('Y-m-d H:i:s');
	
	//dbug($date_time,'date_time');
	
	$insert_sql = "INSERT INTO cars_data (student_id, car_id, username, speed, car_type, custom_field1, custom_field2, custom_field3) VALUES ('$student_id', '$car_id', '$username', '$speed', '$car_type', '$custom_field1', '$custom_field2', '$custom_field3')";
	
	$insert_result = db::doQuery($insert_sql);
	if (!$insert_result) {
		trigger_error('Error - could not insert new record into cars_data table. $insert_sql: '.$insert_sql, E_USER_ERROR);
	}
	
	$new_id = db::getLastID();
	$message = "New record created (id: $new_id)";
	
	setStatusMessage($message, false);
	loadPage("/view.php");
	
	exit;
}

$smarty->assign('template', getPageTemplate());
$smarty->display('default.tpl');
?>