<?php

// This script is called via Python
// saves car data into the DB
// see this article for info on saving/retrieving milliseconds in MYSQL:
// https://www.tutorialspoint.com/how-to-save-time-in-milliseconds-in-mysql
require_once ('../includes/site_config.php');

// get current timestamp, two versions for now as Mysql cant store milliseconds
$date_time = getDateTime();
$date_time_micro = getDateTimeMicro();

// get timestamp in milliseconds
$timestamp_micro = microtime();

// if user has submitted form
if ($_POST) {
	
	//dbug($_POST,'$_POST');
	$txt = "$date_time_micro - POST data received: \n";
	$txt .= print_r($_POST,true);
	
	// sanitise user input
	$school_id = db::makeDBSafe($_POST['school_id']);
	$mac_address = db::makeDBSafe($_POST['mac_address']);
	$car_id = db::makeDBSafe($_POST['car_id']);
	$student_id = db::makeDBSafe($_POST['student_id']);
	$username = db::makeDBSafe($_POST['username']);
	$speed = db::makeDBSafe($_POST['speed']);
	$location = db::makeDBSafe($_POST['location']);
	$car_type = db::makeDBSafe($_POST['car_type']);
	$custom_field1 = db::makeDBSafe($_POST['custom_field1']);
	$custom_field2 = db::makeDBSafe($_POST['custom_field2']);
	$custom_field3 = db::makeDBSafe($_POST['custom_field3']);

	//dbug($date_time,'date_time');
	
	$insert_sql = "INSERT INTO cars_data (school_id, date_time, date_time_micro, student_id, car_id, mac_address, username, speed, location, car_type, custom_field1, custom_field2, custom_field3) VALUES ('$school_id',now(),now(3),'$student_id', '$car_id', '$mac_address', '$username', '$speed', '$location', '$car_type', '$custom_field1', '$custom_field2', '$custom_field3')";
	
	$insert_result = db::doQuery($insert_sql);
	if (!$insert_result) {
		trigger_error('Error - could not insert new record into cars_data table. $insert_sql: '.$insert_sql, E_USER_ERROR);
	}
	
}
else {
	$txt = "$date_time_micro - NO POST data sent \n";
}

echo "Data written to cars_data table in DB: $txt";

// write data to text file
#$filename = 'python_save_data/data.txt';
#$myfile = fopen($filename, "a") or die("Error - Unable to write text file!");
#fwrite($myfile, $txt);
#fclose($myfile); 
#echo "data written to $filename: $txt";
?>