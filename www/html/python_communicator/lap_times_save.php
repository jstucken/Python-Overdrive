<?php

// This script is called via Python
// saves lap times into lap_times DB table
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
	$txt = "$date_time_micro - POST data detected \n";
	$txt .= print_r($_POST,true);
    
    /*
     'student_id':student_id,
        'car_id':car_id,
        'lap_time':lap_time,
        'lap_count':lap_count,
        'speed':speed
        */
	
	// sanitise user input
	$student_id = db::makeDBSafe($_POST['student_id']);
	$car_id = db::makeDBSafe($_POST['car_id']);
	$lap_time = db::makeDBSafe($_POST['lap_time']);
	$lap_count = db::makeDBSafe($_POST['lap_count']);
	$speed = db::makeDBSafe($_POST['speed']);

	//dbug($date_time,'date_time');
	
	$insert_sql = "INSERT INTO lap_times (student_id, car_id, lap_time, lap_count, speed, created, modified) VALUES ('$student_id', '$car_id', '$lap_time', '$lap_count', '$speed', now(), '$date_time_micro')";
	
	$insert_result = db::doQuery($insert_sql);
	if (!$insert_result) {
		trigger_error('Error - could not insert new record into lap_times table. $insert_sql: '.$insert_sql, E_USER_ERROR);
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