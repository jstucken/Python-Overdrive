<?php
/*
* This script allows admin users to edit the details of a particular class
*/

require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/site_config.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/smarty_config.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php');

//dbug($_GET,'$_GET');

// if user has clicked saved on edit page, save new data
if ($_POST) {
	
	//dbug($_POST,'$_POST');
	//dbug($_SESSION,'$_SESSION');
	
	// car_id passed through session
	$class_id = $_SESSION['class_edit_id'];
	
	if (!is_numeric($class_id) OR empty($class_id)) {
		trigger_error('Error - $class_id from session must be numeric and cannot be empty', E_USER_ERROR);
	}
	
	// sanitise user input
	$class_name = $_POST['class_name'];
	$description = $_POST['description'];
	$active = $_POST['active'];
	
	// if checkbox is unticked
	if (empty($active)) {
		$active = 0;
	}
	
	
	$class_name = db::makeDBSafe($class_name);
	$description = db::makeDBSafe($description);
	$active = db::makeDBSafe($active);
	
	// check that class_name is not blank
	if (empty($class_name)) {
		$message = "Error - class name cannot be blank.";
		setStatusMessage($message, true);
		loadPage("/classes_edit.php?class_id=$class_id");
	}
		
	// all ok
	// update database with new user data
	$update_sql = "UPDATE classes SET name = '$class_name', description = '$description', active='$active', modified = NOW() WHERE class_id = '$class_id' LIMIT 1";
	
	//dbug($update_sql,'update_sql');

	if (!$result = $db->doQuery($update_sql))
	{
		trigger_error('Error - Could not update classes table. $update_sql: '.$update_sql, E_USER_ERROR);
	}
	
	$message = "Success - class_id $class_id has been updated.";
	setStatusMessage($message, false);
	loadPage("/classes.php");
	
}
else {
	// else they just opened this page, show form
	$class_id = $_GET['class_id'];

	if (!is_numeric($class_id) OR $class_id < 0) {
		$message = "Error - class_id must be numeric";
		setStatusMessage($message, true);
		loadPage("/classes.php");
	}
	
	// save class_id to session
	$_SESSION['class_edit_id'] = $class_id;
	
	// sanitise the class_id
	$class_id = db::makeDBSafe($class_id);
	
	// get the car data from DB
	$select_sql = "SELECT * FROM classes WHERE class_id='$class_id'";
	$data = $db->getRow($select_sql);
	//dbug($data,'$data');
	
	if (!$data) {
		trigger_error('Error - could not find class in DB. $select_sql: '.$select_sql, E_USER_ERROR);
	}
	
}
	

$smarty->assign('data', $data);
$smarty->assign('template', getPageTemplate());
$smarty->display('default.tpl');
?>