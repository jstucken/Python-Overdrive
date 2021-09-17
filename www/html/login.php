<?php
/**
* Our login handling page which uses inbuilt php functions password_hash() and password_verify()
*
* This page can also be used to MAKE a hashed password to manually insert into the DB
* Example usage: login.php?make_pass=1&plaintext_pass=PASSWORD
*
*
*/
require_once ('includes/site_config.php');
require_once ('includes/smarty_config.php');
require_once ('includes/header.php');


////////////////////// TODO  - MAKE CHANGE PASSWORD FUNCTIONALITY ///////////////////////
////////////////////// TODO  - MAKE CHANGE PASSWORD FUNCTIONALITY ///////////////////////
////////////////////// TODO  - MAKE CHANGE PASSWORD FUNCTIONALITY ///////////////////////
////////////////////// TODO  - MAKE CHANGE PASSWORD FUNCTIONALITY ///////////////////////

// if user has tried to login...
if (!empty($_POST)) {
	
	//dbug($_POST,'$_POST');
	
	// brute force prevention
	// lock out user if they try more than 10 times unsuccessfully
	if ($_SESSION['login_attempts']['counter'] >= 10)
	{
		
		$last_timestamp = $_SESSION['login_attempts']['last_timestamp'];
		$current_timestamp = time();
		
		$timestamp_difference = $current_timestamp - $last_timestamp;
		
		//dbug($last_timestamp,'$last_timestamp');
		//dbug($current_timestamp,'$current_timestamp');
		//dbug($timestamp_difference,'$timestamp_difference');
		
		// 1 minute login failure window
		if ($timestamp_difference <= 60) {
			//die("Too many incorrect login attempts! Please try again later.");
			setStatusMessage("Too many incorrect login attempts! Please try again later.");
			loadPage('/index.php');
		}
	}	

	$clean_email = $db->makeDBSafe($_POST['email']);
	$clean_user_password_guess = $db->makeDBSafe($_POST['password']);
	
	
	// check if user exists in db and get their correct hashed password
	$sql = "SELECT * FROM users WHERE email='{$clean_email}'";

	//dbug($sql);
	$user = $db->getRow($sql);
	
	//dbug($user,'user');

	// do we have a user match in the DB?
	if (!empty($user))
	{
		//echo 'user exists';
		
		// user exists
		// check user's password guess matches the hidden hashed pass in db
		
		//dbug($user['password'],'$user[password]');
		//dbug($clean_user_password_guess,'clean_user_password_guess');
		
		if (password_verify($clean_user_password_guess, $user['password'])) {
			
			//echo 'pass matches!';
			// all ok!
			// update DB last_login_time
			
			$ip_address = $_SERVER['REMOTE_ADDR'];
			$agent = db::makeDBSafe($_SERVER['HTTP_USER_AGENT']);
			
			$update_sql = "UPDATE users SET	last_ip = '$ip_address', last_agent = '$agent', last_login_time = NOW() WHERE user_id = '{$user['user_id']}' LIMIT 1";

			if (!$result = $db->doQuery($update_sql))
			{
				trigger_error('Could not update last_login_time.', E_USER_ERROR);
			}
			
			// add user data into session
			$_SESSION['user']['user_id'] = $user['user_id'];
			$_SESSION['user']['email'] = $user['email'];
			$_SESSION['user']['firstname'] = $user['firstname'];
			$_SESSION['user']['lastname'] = $user['lastname'];
			$_SESSION['user']['admin'] = $user['admin'];
			unset($_SESSION['login_attempts']);
			
			setStatusMessage('Welcome '.$user['firstname'].', new admin features are now available.', false);
			
			// send them to homepage now
			loadPage('/index.php');
		}
		else {
			//echo 'pass dont match';
			setStatusMessage("Incorrect username or password.");
			loadPage('/login.php');
		}
		exit;
	}
	
	// default catch all
	// if the login has failed, we'll catch them here
	
	// brute force prevention
	// check session for number of previos login attempts
	if (empty($_SESSION['login_attempts']['counter'])) {
		$login_attempts = 1;
	}
	else {
		$login_attempts = $_SESSION['login_attempts']['counter'] + 1;
	}
	$_SESSION['login_attempts']['counter'] = $login_attempts;
	$_SESSION['login_attempts']['last_timestamp'] = time();
		
	setStatusMessage("Incorrect username or password.");
	loadPage('/login.php');
	exit;
}

$smarty->assign('template', getPageTemplate());
$smarty->display('default.tpl');
//debug($_SESSION,'_SESSION');
?>