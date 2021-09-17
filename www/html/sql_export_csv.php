<?php
/*
* This script runs some user defined SQL on the database
* and exports the results as a CSV file which the browser downloads
*
* Author: Jonathan Stucken
* Created: 18/6/2021
*/

require_once ('includes/site_config.php');
require_once ('includes/smarty_config.php');
require_once ('includes/header.php');
require_once ('includes/classes/jonoCSV.class.php');


debug($_SESSION,'$_SESSION');

// pre-flight checks for errors
if (empty($_SESSION['sql']['user_sql'])) {
    trigger_error('Error - $_SESSION[sql][user_sql] is blank and should not be', E_USER_ERROR);    
}

// instantiate our CSV writing class
$csv = new jonoCSV();

// SQL to get all records from cars_data DB table, apply a row limit
$limit_sql = null;

$select_sql = $_SESSION['sql']['user_sql'];


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

$today = date("Y-m-d-H-i-s");
$filename = "sql_export_csv_$today.csv";
$full_filename = $file_path.$filename;		// full, absolute file path and file name

// prompt users browser to download the file
$csv->renderCSVtoBrowser($filename);
exit;


?>