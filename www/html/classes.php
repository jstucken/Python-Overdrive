<?php
require_once ('includes/site_config.php');
require_once ('includes/smarty_config.php');
require_once ('includes/header.php');
require_once ('includes/classes/student.class.php');
require_once ('includes/classes/car.class.php');

//dbug($_SESSION,'$_SESSION');

// ensure only admin users (teachers) can access this page
require_once ('includes/admin_login_check.php');

// instantiate our student class
$s = new student();

// if user has submitted form
if ($_POST) {
	
	//dbug($_POST,'$_POST');
	
	// flag to hold error messages
	$errors = null;
	
	// get admin user_id from $SESSION
	// this isn't really used much atm but in future it could be when we have
	// multiple admin users all creating their own classes
	$user_id = $_SESSION['user']['user_id'];
	
	// sanitise user input
	$class_name = $_POST['class_name'];
	$description = $_POST['description'];
	
	if (empty($class_name)) {
		$errors .= 'class_name cannot be blank<br>';
	}
	
	// send them back now if errors present
	if ($errors) {
		$message = "Error - please fix the following: <br><br>$errors";
		setStatusMessage($message, true);
		loadPage("/classes.php");
	}
	
	// make DB safe strings
	$user_id = db::makeDBSafe($user_id);
	$class_name = db::makeDBSafe($class_name);
	$description = db::makeDBSafe($description);
	
	// strip out special characters from class name
	$class_name = db::stripSpecialCharacters($class_name);
	
	// check that nominated class name does not already exist
	$select_sql = "SELECT name FROM classes WHERE name='$class_name'";
	
	//dbug($select_sql,'$select_sql');
	$select_result = $db->getRow($select_sql);
	if (!empty($select_result)) {
		$errors .= "A class with this name ($class_name) already exists. Please choose another class name.";
	}
	
	// send them back now if errors present
	if ($errors) {
		$message = "Error - please fix the following: <br><br>$errors";
		setStatusMessage($message, true);
		loadPage("/classes.php");
	}
	
	
	//dbug($date_time,'date_time');
	// all ok if they get to here, insert new class into DB
	
	$insert_sql = "INSERT INTO classes (user_id, name, description, created, modified) VALUES ('$user_id','$class_name','$description', NOW(), NOW())";
	$insert_result = db::doQuery($insert_sql);
	if (!$insert_result) {
		trigger_error('Error - could not insert new record into classes table. $insert_sql: '.$insert_sql, E_USER_ERROR);
	}
	
	$new_id = db::getLastID();
	$message = "New class created with class_id $new_id <br><br>";
	
	setStatusMessage($message, false);
	loadPage("/classes.php");
}
else {
	
	// handle default page load
	// select all classes from classes table
	$classes = $s->getAllClassesWithStudents();
	
	//dbug($classes,'classes');
	
}

$smarty->assign('classes', $classes);
$smarty->assign('template', getPageTemplate());
$smarty->display('default.tpl');
?>