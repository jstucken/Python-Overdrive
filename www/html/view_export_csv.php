<?php
/*
* This script selects data from the cars_data table from the database
* and prompts the browser to download a CSV file.
*
* It can also write to a CSV file on the local disk
*
* Author: Jonathan Stucken
* Created: 21/5/2021
*/

require_once ('includes/site_config.php');
require_once ('includes/smarty_config.php');
require_once ('includes/header.php');
require_once ('includes/classes/jonoCSV.class.php');

// full filepath on disk where the CSV file will be written, including trailing slash
$file_path = '/home/pi/Python-Overdrive/csv_files/';

// should we limit the data set to a certain amount of records?
// to disable this, comment out the line below or set it to 0
$limit = 3;

// instantiate our CSV writing class
$csv = new jonoCSV();

// SQL to get all records from cars_data DB table, apply a row limit
$limit_sql = null;

if ($limit) {
	$limit_sql = "LIMIT $limit";
}

$select_sql = "
SELECT
    id,
    school_id,
    DATE_FORMAT(date_time, '%d/%m/%Y') as date,
    DATE_FORMAT(date_time_micro, '%H:%i:%S') as time,
    DATE_FORMAT(date_time_micro, '%S.%f') as milliseconds,
    student_id,
    car_id,
    mac_address,
    username,
    speed,
    location,
    car_type,
    custom_field1,
    custom_field2,
    custom_field3
FROM cars_data
ORDER BY id DESC
$limit_sql";

// query the DB
$select_results = $db->getRows($select_sql);
//dbug($select_results,'select_results');

// determine the column headings from DB and add to our CSV
$first_row_headings = array();
foreach ($select_results[0] as $key => $value) {
		//dbug($key,'$key');
		$first_row_headings[] = $key;
}

//debug($first_row_headings,'first_row_headings');

// flatten first row headings into one line (not an array), and add to the CSV
$first_row_headings_flat = $csv->array2csv($first_row_headings);
//dbug($first_row_headings_flat,'$first_row_headings_flat');
$csv->addLine($first_row_headings_flat);

// build data set from records returned from DB
foreach ($select_results as $key => $row) {
	
	//dbug($row,'row');
	// flatten the row into a CSV friendly format
	$flat_row = $csv->array2csv($row);
	
	//dbug($flat_row,'$flat_row','blue');
	
	// add this row to the CSV file we're building
	$csv->addLine($flat_row);
}

// get the data ready to write to CSV file
$csv_data = $csv->getLines();
//dbug($csv_data,'$csv_data');
//exit;


// get current date and time, to use in the CSV filename
$today = date("Y-m-d-H-i-s");
$filename = "cars_data_$today.csv";
$full_filename = $file_path.$filename;		// full, absolute file path and file name
//dbug($filename,'$filename');

// write the CSV file to disk - DISABLED FOR NOW
// $file_path must include the CSV filename in it and also be a writeable dir (chmod 777)
// Seeing this script will be called by PHP/Mysql with www-data user, make sure the dir
// is owned by www-data
//$csv->writeCSVFile($full_filename);

// prompt users browser to download the file
$csv->renderCSVtoBrowser($filename);
exit;


?>