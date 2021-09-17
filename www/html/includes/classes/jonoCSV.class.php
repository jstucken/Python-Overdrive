<?php

/**
* Jono's CSV class
* Gets CSV data from a URL
* and then you can reference the CSV columns like accessing a database table
* eg:
* $data['column_name'];
*/
class jonoCSV
{
	public $csv_file;
	public $columns = array();			// will hold all our column names
	public $ignore_rows = array();		// contains which data rows to discard eg row 1 column headings
	
	public $lines_array = array();		// holds data lines waiting to be written to a CSV file

	
	/*
	* constructor method
	*/
	public function __construct() {


	}
	
	
	/*
	* set what CSV file the class should work with
	*/
	public function setDataSource($csv_file) {
		$this->csv_file = $csv_file;
	}
	
	
	/**
	* Add a new column name which this class can access eg FirstName
	* Match up each CSV column with its corresponding column key 
	*/
	public function addColumn($column_name, $key) {
		
		$this->columns[$column_name] = $key;
		
		// TODO: this php function may come in handy here:
		// array_keys
		
	}
	
	
	/**
	* Returns an array with all the column names which have been added
	*/
	public function getColumns() {
		
		return $this->columns;
	}
	
	/**
	*
	*/
	public function ignoreRow($key) {
		
		$this->ignore_rows[] = $key;
		//dbug($this->ignore_rows,'$this->ignore_rows');
	}
	
	
	/*
	* Actually get and return the csv data in array format
	*/
	public function getData() {
			
		
		$data = array_map('str_getcsv', file($this->csv_file));
		
		//dbug($data,'$data raw');
		
		// remove any ignored rows eg first row column headings
		foreach ($this->ignore_rows as $row_key)
		{
			unset($data[$row_key]);
		}
		// reorder array keys
		$data = array_values($data);
		
		
		// will contain nice clean data for the columns we need only
		$new_data = array();	
		
		// loop thru data rows...
		foreach ($data as $key => $row) {
			
			// only collate data for the columns we want
			foreach ($this->columns as $column_name => $column_key)
			{
				//dbug($row,'$row', 'black');
				//dbug($column_name,'column_name');
				//dbug($column_key,'column_key');
				$new_data[$key][$column_name] = $row[$column_key];
			}
		
		}
		
		return $new_data;
		//dbug($new_data,'$new_data', 'purple');
	}
	
	
	/*
	* Converts a flat single dimensional array to a CSV string
	* array $array The array to process eg from mysql result
	* string $field optional The single field to extract eg close
	* string $encapsulate_char optional A character to encapsulate each item with eg '
	*/
	public static function array2csv($array, $field=null, $encapsulate_char=null)
	{
		$out = null;
		
		$count = 0;
		foreach ($array as $key => $row) {
			
			// add comma after every row except the first 
			if ($count != 0) {
				$out .= ',';
			}
			
			// Encapsulate data if supplied
			if (!empty($encapsulate_char)) {
				$out .= $encapsulate_char;
			}
			
			// use the specific field if supplied
			if (empty($field)) {
				// no field supplied, just use the entries in the array, assuming it's 1D
				$out .= $row;
				
			}
			else {
				// use the specific field as it's been supplied
				$out .= $row[$field];
			}
			
			// Encapsulate data AGAIN if supplied
			if (!empty($encapsulate_char)) {
				$out .= $encapsulate_char;
			}
			
			$count++;
		}
		
		return $out;
	}
	
	
	/*
	* Adds a line to a CSV file
	* Data will not be hard written until writeCSVFile() is called
	*/
	public function addLine($line) {
	
		// add to our array
		$this->lines_array[] = $line;
	}
	
	
	/*
	* Added 26-5-2021
	* Use to debug the CSV data, to see that data is awaiting to be written to file
	* returns a numerical array with the lines of data
	*/
	public function getLines() {
		
		return $this->lines_array;
	}
	
	
	/*
	* Writes a CSV file line by line
	* $file_path must include the CSV filename in it and also be a writeable dir
	*/
	public function writeCSVFile($file_path) {
		
		//dbug($file_path,'file_path');
		//dbug($this->lines_array,'$this->lines_array');
		
		$file = fopen($file_path,"w");
		
		foreach ($this->lines_array as $line) {
			
			//echo "$line<br>";
			fputcsv($file,explode(',',$line));
		}

		fclose($file);
		
		// clear the lines_array for future use
		//$this->lines_array = array();
	}
	
	
	/*
	* Forces the user's browser to download the CSV file
	* call this once you have written the CSV file to disk and have it ready
	* Be careful not to display anything else on the screen which may interrupt this process
	*
	* string $filename - the actual filename to ask the user to download
	*/
	public function renderCSVtoBrowser($filename) {
	
		// alternative method to the below would be to pull up the filecontents from disk
		//$file_contents = file_get_contents($full_filename);
		
		// get all the lines of the CSV file as an array
		$lines = $this->getLines();
		
		//dbug($lines,'$lines');
		
		// flatten all the lines into one big line, removing them from their array
		$lines_flat = '';
		
		// gather all the  lines
		foreach ($lines as $line) {
			$lines_flat .= "$line\n";		// note the newline character
		}
		
		// setup browser headers to receive the CSV file
		ob_end_clean();
		header( 'Content-Type: text/csv' );
		header( 'Content-Disposition: attachment;filename='.$filename);

		echo $lines_flat;
	}
	
	
}
?>