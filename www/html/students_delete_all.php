<?php
require_once ('includes/site_config.php');
require_once ('includes/smarty_config.php');
require_once ('includes/header.php');

// ensure only admin users (teachers) can access this page
require_once ('includes/admin_login_check.php');

// select all the usernames so we can delete from Linux system
$select_sql = "SELECT username FROM students ORDER BY student_id ASC";
$select_results = $db->getRows($select_sql);

if (!$select_results) {
	$message = "Error - No students found in database!";
	setStatusMessage($message, true);
	loadPage("/students.php");
}
//dbug($select_results,'$select_results');

// collect all usernames
$usernames = array();
foreach ($select_results as $result) {
	$username = $result['username'];
	
	//dbug($username,'$username');
	
	// delete the Linux user
	$command = "sudo userdel -r $username";
	run_command($command);
}

// delete all the students from the database
// truncate the table
$delete_sql = "TRUNCATE TABLE students;";

$delete_result = db::doQuery($delete_sql);
if (!$delete_result) {
	trigger_error('Error - could not truncate students table. $delete_sql: '.$delete_sql, E_USER_ERROR);
}

// remove assigned cars from the students_cars table
$assigned_cars_delete_sql = "TRUNCATE TABLE students_cars";

$assigned_cars_delete_result = db::doQuery($assigned_cars_delete_sql);
if (!$assigned_cars_delete_result) {
	trigger_error('Error - could not truncate students_cars table. $assigned_cars_delete_sql: '.$assigned_cars_delete_sql, E_USER_ERROR);
}

$message = "All students deleted, including their associated linux user accounts";

setStatusMessage($message, false);
loadPage("/students.php");


$smarty->assign('results', $select_results);
$smarty->assign('template', getPageTemplate());
$smarty->display('default.tpl');
?>