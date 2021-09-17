<?php

/*
* This script checks that the user has logged in
* If not, they are redirected to login screen
*/

// are they logged in as an admin user?
if (empty($_SESSION['user']['admin']))
{
	setStatusMessage("You need admin privileges to access that page.");
	loadPage("/login.php");
	exit;
}

?>