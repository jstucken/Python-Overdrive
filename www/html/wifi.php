<?php
require_once ('includes/site_config.php');
require_once ('includes/smarty_config.php');
require_once ('includes/header.php');

// ensure only admin users (teachers) can access this page
require_once ('includes/admin_login_check.php');



// if user has submitted form
// hash their wifi password and add to /etc/wpa_supplicant/wpa_supplicant.conf
if ($_POST) {
	
	//dbug($_POST,'$_POST');
	//exit;
    
    // check user input for errors
	// flag to hold error messages
	$errors = null;
	
	// grab the username and password posted through via HTML form
	// strip out any funny characters
	// sanitise user input
	$username = $_POST['username'];
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];
	
	// error checking
	if (empty($username)) {
		$errors .= 'Username cannot be blank<br>';
	}
	else if (strpos($username, '.') !== false) {
		$errors .= 'Your network username should not contain fullstops<br>';
	}
    else if (strpos($username, '@') !== false) {
		$errors .= 'Your network username should not contain the @ symbol<br>';
	}
    else if (strpos($username, ' ') !== false) {
		$errors .= 'Your network username should not contain spaces<br>';
	}
    
    if (empty($password)) {
		$errors .= 'Password cannot be blank<br>';
	}
    else if ($password != $confirm_password) {
       $errors .= 'Passwords must match<br>'; 
    }

	
	if ($errors) {
		
		$message = "Error - please fix the following: <br><br>$errors";
		setStatusMessage($message, true);
		loadPage("/wifi.php");
	}
    
    //setStatusMessage($message, true);
	//loadPage("/students.php");
	
    echo "**********************************<br>";
	echo "User data OK, proceeding...<br>";
	flushOutput(null);
	sleep(1);
    
	//////////////////////////////////
	//////////////////////////////////
	// We will now run a series of command line arguements, via PHP, to setup DET wifi

	// encrypt their password for Linux
    echo "Hashing password... <br>";
	$command = SHELL_SCRIPTS_PATH."get_wpa_supplicant_hash.sh $password";
	$hashed_password = run_command($command);
    
    // strip out newlines
    $hashed_password = preg_replace("/\r|\n/", "", $hashed_password);
	
    //dbug($hashed_password,'hashed_password');
	
    flushOutput(null);
    
    // From our site_config.php file, get the template to write
    // to /etc/wpa_supplicant/wpa_supplicant.conf
    $wpa_supplicant_template = WPA_SUPPLICANT_TEMPLATE;
    
    //dbug($wpa_supplicant_template, 'wpa_supplicant_template');
    
    // add in the user's username and password to the template
    $wpa_supplicant_template = str_replace('USERNAME_HERE', $username, $wpa_supplicant_template);
    $wpa_supplicant_template = str_replace('HASHED_PASSWORD_HERE', $hashed_password, $wpa_supplicant_template);
    
    //dbug($wpa_supplicant_template, 'wpa_supplicant_template','green');

    // backup the existing wpa_supplicant.conf file, if it exists
	sleep(1);
	flushOutput(null);
	
	echo "Backing up existing wpa_supplicant.conf file... <br>";
    if (file_exists('/etc/wpa_supplicant/wpa_supplicant.conf')) {
		$command = "sudo mv /etc/wpa_supplicant/wpa_supplicant.conf /etc/wpa_supplicant/wpa_supplicant.conf_BACKUP";
		
		run_command($command);
    }
	
	// write new contents to wpa_supplicant.conf
	
	// create new file
	echo 'Creating new wpa_supplicant.conf file...<br>';
	run_command('sudo touch /etc/wpa_supplicant/wpa_supplicant.conf');
	
	// allow pi user to write to the file
	run_command('sudo chmod 777 /etc/wpa_supplicant/wpa_supplicant.conf');
	
	sleep(1);
	flushOutput(null);
	
	// write new template data to the file
	echo "Writing new contents to wpa_supplicant.conf file... <br>";
	file_put_contents('/etc/wpa_supplicant/wpa_supplicant.conf', $wpa_supplicant_template);
	
	// chmod back to 644 
	run_command('sudo chmod 644 /etc/wpa_supplicant/wpa_supplicant.conf');
	flushOutput(null);
	
	// refresh the wifi using the bash script
	echo "Refreshing the wifi connection...<br>";
	sleep(1);
	flushOutput(null);
	
	$command = SHELL_SCRIPTS_PATH."refresh_wifi.sh";
	$output = run_command($command, true);
	
	echo "All done!<br>";
	echo "**********************************<br><br>";
	
	$message = 'New wifi network set. Please allow 30 seconds for changes to come into effect. The desktop wifi icon should flash then turn solid blue once successful.';
	
	setStatusMessage($message, false);
	loadPage("/wifi.php");
}
else {
	
	// handle default page load
	
	
    
    
}


//dbug($students,'students');

$smarty->assign('template', getPageTemplate());
$smarty->display('default.tpl');
?>