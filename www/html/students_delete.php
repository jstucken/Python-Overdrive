<?php
require_once ('includes/site_config.php');
require_once ('includes/smarty_config.php');
require_once ('includes/header.php');

// ensure only admin users (teachers) can access this page
require_once ('includes/admin_login_check.php');

// if user has submitted form
if ($_GET['student_id']) {
	
	$student_id = db::makeDBSafe($_GET['student_id']);
	
	// safety check
	if (empty($student_id) OR !is_numeric($student_id)) {
		trigger_error('Error - student_id cannot be empty and must be numeric', E_USER_ERROR);
	}
	
	// get the students username so we can find the associated linux account
	$select_sql = "SELECT username FROM students WHERE student_id='$student_id'";
	$select_result = $db->getRow($select_sql);
	
	if (!$select_result) {
		trigger_error('Error - could not find that student username from students_table. $select_sql: '.$select_sql, E_USER_ERROR);
	}
	
	//dbug($select_result,'$select_result');
	$username = $select_result['username'];
	
	// delete the student from the database
	$delete_sql = "DELETE FROM students WHERE student_id='$student_id' LIMIT 1";
	
	//dbug($delete_sql,'delete_sql');
	
	$delete_result = db::doQuery($delete_sql);
	if (!$delete_result) {
		trigger_error('Error - could not delete student from students_table. $delete_sql: '.$delete_sql, E_USER_ERROR);
	}
	
	// remove assigned cars for this student from the students_cars table
	$assigned_cars_delete_sql = "DELETE FROM students_cars WHERE student_id='$student_id'";
	
	$assigned_cars_delete_result = db::doQuery($assigned_cars_delete_sql);
	if (!$assigned_cars_delete_result) {
		trigger_error('Error - could not delete assigned cars from students_cars table. $assigned_cars_delete_sql: '.$assigned_cars_delete_sql, E_USER_ERROR);
	}
	
	$message = "student_id $student_id deleted and linux account for $username removed.";
	
	//////////////////////////////////
	// Now we need to remove the user account from the raspberry pi
	// run a shell exec to add the new user
	// Deleting user from Linux
	
	$command = "sudo userdel -r $username";
	run_command($command);
	
	setStatusMessage($message, false);
	loadPage("/students.php");
	exit;
	
}
else {
	
	// handle default page load
	// select all students from students table
	$select_sql = "SELECT * FROM students ORDER BY lastname ASC";
	$select_results = $db->getRows($select_sql);
	
	//dbug($select_results,'select_results');
	
}

$smarty->assign('results', $select_results);
$smarty->assign('template', getPageTemplate());
$smarty->display('default.tpl');
?>