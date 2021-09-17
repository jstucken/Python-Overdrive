<?php
/*
* This script allows admin users to edit the details of a particular class
*/

require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/site_config.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/smarty_config.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/classes/car.class.php');
require_once ('includes/classes/student.class.php');

// ensure only admin users (teachers) can access this page
require_once ('includes/admin_login_check.php');

//instantiate our classes which this script uses
$s = new student();
$c = new car();

//dbug($_GET,'$_GET');
//dbug($_POST,'$_POST');
// if user has clicked saved on edit page, save new data
if ($_POST) {
	
	//dbug($_POST,'$_POST');
	
	// grab student id from session
	$student_id = $_SESSION['student_edit_id'];
	
	if (empty($student_id) OR !is_numeric($student_id)) {
		trigger_error('Error - student_edit_id from session cannot be empty and must be numeric', E_USER_ERROR);
	}
	
	// sanitise user input
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$class_id = $_POST['class_id'];
	$assigned_cars = $_POST['assigned_cars'];
	
	// error checking
	if (!db::isAlphanumeric($firstname)) {
		$errors .= 'firstname cannot be blank or contain special characters<br>';
	}
	if (!db::isAlphanumeric($lastname)) {
		$errors .= 'lastname cannot be blank or contain special characters<br>';
	}
    
   // dbug($class_id,'$class_id');
	if (!is_numeric($class_id)) {
		$errors .= 'class_id must be numeric<br>';
	}
	
	// send them back now if errors present
	if ($errors) {
		
		$message = "Error - please fix the following: <br><br>$errors";
		setStatusMessage($message, true);
		loadPage("/students_edit.php?student_id=$student_id");
	}
	
	// all ok, update student in str_replace
		
	// all ok
	// update database with new user data
	$update_sql = "UPDATE students SET class_id='$class_id', firstname='$firstname', lastname='$lastname', modified = NOW() WHERE student_id = '$student_id' LIMIT 1";
	//dbug($update_sql,'update_sql');

	if (!$result = $db->doQuery($update_sql))
	{
		trigger_error('Error - Could not update students table. $update_sql: '.$update_sql, E_USER_ERROR);
	}
	
	// now save their chosen cars into students_cars table
	// first delete any currently assigned cars this student has
	$delete_sql = "DELETE FROM students_cars WHERE student_id='$student_id'";
	$delete_result = db::doQuery($delete_sql);
	
	if (!$delete_result) {
		trigger_error('Error - could not delete cars from students_cars table. $delete_sql: '.$delete_sql, E_USER_ERROR);
	}
	
	// add their newly chosen cars to students_cars table
	foreach ($assigned_cars as $car_id) {
		
		$insert_sql = "INSERT INTO students_cars (student_id, car_id, created, modified) VALUES ('$student_id','$car_id', NOW(), NOW())";
		
		//dbug($insert_sql,'$insert_sql');
		
		$insert_result = db::doQuery($insert_sql);
		if (!$insert_result) {
			trigger_error('Error - could not insert new record into students_cars table. $insert_sql: '.$insert_sql, E_USER_ERROR);
		}
	}
	
	
	$message = "Success - student_id $student_id has been updated.";
	setStatusMessage($message, false);
	loadPage("/students.php");
	
}
else {
	// else they just opened this page, show form
	$student_id = $_GET['student_id'];

	if (!is_numeric($student_id) OR $student_id < 0) {
		$message = "Error - student_id must be numeric";
		setStatusMessage($message, true);
		loadPage("/students.php");
	}
	
	// save student_id to session
	$_SESSION['student_edit_id'] = $student_id;
	
	// sanitise the student_id
	$student_id = db::makeDBSafe($student_id);
	
	// get the students data
	$student = $s->getStudent($student_id);
	//dbug($student,'$student');
	
	if (!$student) {
		trigger_error('Error - could not find student in DB. $select_sql: '.$select_sql, E_USER_ERROR);
	}
	
	// get all classes to populate select box
	$classes = $s->getAllClasses();
	//dbug($classes,'classes');
	
	// get all available cars in db to populate checkbox
	$saved_cars = $c->getAllSavedCars();
	//debug($saved_cars,'saved_cars','blue');
	
}
	
$smarty->assign('s', $s);	// allow smarty template to access our student class object
$smarty->assign('student_id', $student_id);
$smarty->assign('student', $student);
$smarty->assign('saved_cars', $saved_cars);
$smarty->assign('classes', $classes);
$smarty->assign('template', getPageTemplate());
$smarty->display('default.tpl');
?>