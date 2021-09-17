<?php

/*
* This script exports all the students from the Web App into a local
* CSV file, which Andrew's shell script can then use to create
* local user accounts on the Linux machine.
* created by: jstucken 6/09/2021
*/

// define file_path and file_name where to save the CSV
$file_path = '/home/pi/Python-Overdrive/csv_files/';
$file_name = 'students.csv';

require_once ('includes/site_config.php');
require_once ('includes/smarty_config.php');
require_once ('includes/header.php');
require_once ('includes/classes/student.class.php');
require_once ('includes/classes/jonoCSV.class.php');

// ensure only admin users (teachers) can access this page
require_once ('includes/admin_login_check.php');

// instantiate our CSV writing class
$csv = new jonoCSV();

// setup the CSV field names
/*
$first_row_headings[] = 'lastname';
$first_row_headings[] = 'firstname';
$first_row_headings[] = 'username';
$first_row_headings[] = 'class_id';
$first_row_headings[] = 'password';

$first_row_headings_flat = $csv->array2csv($first_row_headings);
$csv->addLine($first_row_headings_flat);
*/

// get all the students from students table
$select_sql = "SELECT lastname, firstname, username, class_id, 'default' as password FROM students ORDER BY student_id ASC";

// query the DB
$select_results = $db->getRows($select_sql);


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

// write CSV file to local disk
$csv->writeCSVFile($file_path.$file_name);

$message = "CSV file written to disk, located in:<br>
$file_path
<br>
Please now run the following commands from the CLI:<br><br>

cd $file_path<br><br>

./addUsers-csv.sh $file_path"."$file_name";
	
setStatusMessage($message, false);
loadPage("/students.php");

?>