<?php
/*
* Main site configuration file.
* All our site wide constants etc live here
*/

// path to the original Python scripts. These get copied to new student accounts
// note: the overdrive class does not get copied into student directories
define('PYTHON_SCRIPTS_PATH', '/home/pi/Python-Overdrive/student_files/');

// where our custom bash scripts live
define('SHELL_SCRIPTS_PATH', '/home/pi/Python-Overdrive/shell_scripts/');

// path to site
define('DOCUMENT_ROOT', '/var/www/html/');

// where publically inaccessible stuff should live (eg error logs)
define('SYSTEM_ROOT', '/var/www/html/');	

// Wifi template config data to write to /etc/wpa_supplicant/wpa_supplicant.conf
// Works for DET Internet @ Edge schools
// Values: USERNAME and HASHED_PASSWORD_HERE below get replaced by our PHP script
// when the user runs the wifi connection feature
$wpa_supplicant_template = '
ctrl_interface=DIR=/var/run/wpa_supplicant GROUP=netdev
update_config=1
country=AU

network={
    ssid="detnsw"
    proto=RSN
    key_mgmt=WPA-EAP
    pairwise=CCMP
    auth_alg=OPEN
    eap=PEAP
    identity="detnsw\USERNAME_HERE"
    password=hash:HASHED_PASSWORD_HERE
    phase1="peaplabel=0"
    phase2="MSCHAPv2"
    priority=10
}
';

define('WPA_SUPPLICANT_TEMPLATE', $wpa_supplicant_template);

// user friendly human readable date format for MySQL date fields
define('READABLE_DATE_FORMAT', '%d/%m/%Y %T');

// start the session
session_start();

// these will be included on every page of the site
require_once(DOCUMENT_ROOT.'includes/common_functions.php');

// set our custom error handler which will run when trigger_error is called
set_error_handler("customErrorHandler");	// in common_functions.php

// db class
require_once(DOCUMENT_ROOT.'/includes/classes/db.class.php');

// our site wide constants
define('SITE_TITLE', 'DET Python Anki Overdrive - Local Database App');

// our error logs dir on the server
define('ERROR_LOG_PATH', SYSTEM_ROOT.'error_logs/');

// email address where site notifications are sent (eg new resgistrations)
define('ADMIN_EMAIL', 'stooks@protonmail.com');

// email address where debug emails are sent
define('DEBUG_EMAIL', 'stooks@protonmail.com');

// domain name without the http://
define('SITE_DOMAIN', $_SERVER['SERVER_NAME']);

// site url including the http://
define('SITE_URL', 'http://'.$_SERVER['SERVER_NAME'].'/');


// connect to our local db
$db_name = 'det_anki';
$u = 'det_web_app';
$p = '@ay4hBxhsnHdN}7S';

$db = new db($db_name, $u, $p);

?>
