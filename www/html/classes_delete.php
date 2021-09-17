<?php
require_once ('includes/site_config.php');
require_once ('includes/smarty_config.php');
require_once ('includes/header.php');

// ensure only admin users (teachers) can access this page
require_once ('includes/admin_login_check.php');

/*
* This page is used by admin users to delete classes
*/

// class_id passed by GET
$class_id = $_GET['class_id'];

// sanitise for DB
$class_id = db::makeDBSafe($class_id);

// sanity checking
if (empty($class_id)) {
	trigger_error('Error - $class_id cannot be empty', E_USER_ERROR);
}

if (!is_numeric($class_id)) {
	trigger_error('Error - $class_id must be numeric', E_USER_ERROR);
}

// delete the class from the database
$delete_sql = "DELETE FROM classes WHERE class_id='$class_id' LIMIT 1";

//dbug($delete_sql,'delete_sql');

$delete_result = db::doQuery($delete_sql);
if (!$delete_result) {
	trigger_error('Error - could not delete class from classes table. $delete_sql: '.$delete_sql, E_USER_ERROR);
}


// if any students are assigned to this class, set their class now to 0 ('None')
// update database with new user data
$update_sql = "UPDATE students SET class_id = '0', modified = NOW() WHERE class_id = '$class_id'";
//dbug($update_sql,'update_sql');

if (!$result = $db->doQuery($update_sql))
{
	trigger_error('Error - Could not update students table. $update_sql: '.$update_sql, E_USER_ERROR);
}


// success
$message = "class_id $class_id deleted.";


setStatusMessage($message, false);
loadPage("/classes.php");
	
?>