<?php
require_once ('includes/site_config.php');
require_once ('includes/smarty_config.php');
require_once ('includes/header.php');
require_once ('includes/classes/student.class.php');

// ensure only admin users (teachers) can access this page
require_once ('includes/admin_login_check.php');


//instantiate our student class which this script uses
$s = new student();

// if user has submitted form
if ($_POST) {
	
	//dbug($_POST,'$_POST');
	//exit;
	// flag to hold error messages
	$errors = null;
	
	// grab the username and password posted through via HTML form
	// strip out any funny characters
	// sanitise user input
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$class_id = $_POST['class_id'];
	$password = $_POST['password'];
	
	// error checking
	if (!db::isAlphanumeric($firstname)) {
		$errors .= 'firstname cannot be blank or contain special characters<br>';
	}
	if (!db::isAlphanumeric($lastname)) {
		$errors .= 'lastname cannot be blank or contain special characters<br>';
	}
	if (!is_numeric($class_id)) {
		$errors .= 'class_id must be numeric<br>';
	}
	if (!db::isAlphanumeric($password)) {
		$errors .= 'password cannot be blank or contain special characters<br>';
	}
	
	// make DB safe strings
	$firstname = db::makeDBSafe($firstname);
	$lastname = db::makeDBSafe($lastname);
	$class_id = db::makeDBSafe($class_id);
	
	// make a lowercase username
	$username = $firstname.'.'.$lastname;
	$username = strtolower($username);	// make lowercase
	
	// check that user does not already exist
	$select_sql = "SELECT * FROM students WHERE username='$username'";
	$select_result = $db->getRow($select_sql);
	if (!empty($select_result)) {
		$errors .= "The username <strong>$username</strong> already exists! Please choose another.";
	}
	
	// send them back now if errors present
	if ($errors) {
		
		$message = "Error - please fix the following: <br><br>$errors";
		setStatusMessage($message, true);
		loadPage("/students.php");
	}
	
	
	
	//setStatusMessage('all ok', false);
	//loadPage("/students.php");
	//exit;
	
	//dbug($date_time,'date_time');
	// all ok if they get to here, insert new student into DB
	$insert_sql = "INSERT INTO students (class_id, firstname, lastname, username, created, modified) VALUES ('$class_id','$firstname','$lastname','$username', NOW(), NOW())";
	$insert_result = db::doQuery($insert_sql);
	if (!$insert_result) {
		trigger_error('Error - could not insert new record into students table. $insert_sql: '.$insert_sql, E_USER_ERROR);
	}
	
	$new_id = db::getLastID();
	$message = "New record created in students table (id: $new_id) <br><br>";
	
	setStatusMessage($message, false);
	loadPage("/students.php");
	
	/*
	* DISABLED OLD STUDENT FUNCTIONALITY 7-9-2021
	* as user accounts will now be created by Andrew's Shell script
	*
	//////////////////////////////////
	//////////////////////////////////
	// We will now run a series of command line arguements, via PHP, to setup new user_error
	// and copy relevant files
	//
	// Use shell exec to add the new user
	// Followed this tute (worked 26-5-2021!):
	// https://unix.stackexchange.com/questions/115054/php-shell-exec-permission-on-linux-ubuntu
	// see also: https://stackoverflow.com/questions/5652986/php-sudo-in-shell-exec

	//echo "Creating new username <strong>$username</strong> with the password <strong>$password</strong><br>";
	
	//run_command("whoami");
	//run_command("pwd");
	
	// encrypt their password for Linux
	//echo "Encrypting password for Linux... <br>";
	
	$salt = rand();	// make a random number for the salt
	$command = "perl -e 'print crypt(\"$password\", \"$salt\"),\"\n\"'";
	$hashed_pass = run_command($command);	// get the returned output from this command
	
	//dbug($hashed_pass,'hashed_pass');
	
	// check that the hash was returned by CLI
	if (empty($hashed_pass)) {
		trigger_error('Error - could not obtain Linux hashed password', E_USER_ERROR);
	}
	
	//echo "Now adding student as new linux user <strong>$username</strong> <br>";
	
	// syntax should be:
	// useradd -m -p EncryptedPasswordHere username
	// see https://www.cyberciti.biz/tips/howto-write-shell-script-to-add-user.html

	// remove newline chars which wrecks things
	$hashed_pass = str_replace(array("\n", "\r"), '', $hashed_pass);
	
	// command to add new user to the system using the one-way salted hashed password
	$command = "sudo useradd -m -p $hashed_pass $username";
	//dbug($command,'$command','green');
	
	run_command($command);
	
	
	$message = "Done! New linux user $username should now be able to login using SSH etc";
	
	//echo "Checking updated contents of /home dir...";
	//$command = "sudo ls /home";
	$command = "ls /home";
	$ls = run_command($command);
	
	//dbug($ls,'$ls');
	
	//echo '<hr>';
	//echo '<br><br>';
	//echo '<strong>User added - <a href="students.php">return</a> to setup students page</strong>';
	//exit;
	
	$python_scripts_path = PYTHON_SCRIPTS_PATH;
	
	// copy all required files for the new student
	$new_student_path = "/home/$username/";
	
	//$command = "sudo cp -R $www_path $new_student_path";	// old copy command
	
	// copy everything in student_files dir needed by students
	$command = "sudo rsync -ra $python_scripts_path $new_student_path";
	run_command($command);
	
	// change ownership permissions so student can edit the files
	$command = "sudo chown -R $username:$username /home/$username/";
	run_command($command);
	
	// delete the www directory
	
	
	//dbug($command,'$command');
	
	//exit;
	*/
	
}
else {
	
	// handle default page load
	
	// get all available classes which students can be assigned to
	$classes = $s->getAllClasses();
	
	//dbug($classes,'$classes');
	
	// select all students from students table
	$students = $s->getAllStudents();
	
	//dbug($students,'students','purple');
	
}


//dbug($students,'students');

$smarty->assign('classes', $classes);
$smarty->assign('students', $students);
$smarty->assign('template', getPageTemplate());
$smarty->display('default.tpl');
?>