<?php


/**
* Our Database class
*/
class db
{
	public $db_name;
	public $db_user;
	public $db_pass;
    public $return_nice_error = false;      // useful to get errors to fail nicely
    

	public static $mysqli;	// our static mysqli property use by this class
	
	// connect to the db automatically on calling this class
	public function __construct($db_name, $db_user, $db_pass, $db_host = 'localhost') {
		
		
		self::$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
		if (self::$mysqli->connect_errno) {
			echo "Failed to connect to MySQL: (" . self::$mysqli->connect_errno . ") " . self::$mysqli->connect_error;
			exit;
		}
	}
	
	
	/*
	* strips out any special characters from a string
	*/
	public function stripSpecialCharacters($string) {
	  
		$string = str_replace("'", "", $string); // Replaces apostrophes
		$string = str_replace('"', '', $string); // Replaces apostrophes
		$string = str_replace('`', '', $string); // Replaces apostrophes
		$string = preg_replace('/[^A-Z a-z0-9\-]/', '', $string); // Removes special chars except spaces
		$string = preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
	
		return $string;
	}
	
	
	
	/*
	* Checks to make sure that a string only contains Alphanumeric characters and numbers
	* See https://www.php.net/ctype_alnum
	*/
	public function isAlphanumeric($string) {
		
		if (ctype_alnum($string)) {
			return true;
		}
		else {
			return false;
		}
	}
	
	// sterilises a string to prevent sql injection
	public function makeDBSafe($var) {
	
		$var = self::$mysqli->real_escape_string($var);
		return $var;
	}
	
	
	/*
	* Converts any legible string into a mysql safe Date
	* eg converts 2/3/2017 into 2017-02-03
	*/
	public function makeDBSafeDate($var) {

		// prevent empty dates being converted into todays date
		if (empty($var)) {
			return;
		}
		
		$date = new DateTime($timestamp);
		$db_date = $date->format('Y-m-d');

		return $db_date;
		
	}
	
	
	/*
	* Converts legible time string into a mysql safe time
	* eg converts 4:15pm into 2017-02-03 16:15:00
	*/
	public function makeDBSafeTime($var) {
		
		// prevent empty dates being converted into todays date
		if (empty($var)) {
			return;
		}

		$date = new DateTime($var);
		$db_date = $date->format('H:i:s');

		return $db_date;
	}
	
	
	/*
	* Converts any legible string into a mysql safe datetime
	* eg converts 4:15pm 2/3/2017 into 2017-02-03 04:15:00
	*/
	public function makeDBSafeDateTime($var) {
		
		// prevent empty dates being converted into todays date
		if (empty($var)) {
			return;
		}

		$date = new DateTime($var);
		$db_date = $date->format('Y-m-d H:i:s');

		return $db_date;
	}
		
		
	/*
	* Gets a MYSQL safe date in the past, from today
	* @param string $time_period - How many days ago eg '365' will return the date one year ago
	* from today
	* @return string $date_past - The past date in the MYSQL format of YYYY-mm-dd hh:mm:ss
	*/
	public function getDateInPast($time_period) {
	
		//$time_period = '3 hours';		// for testing only
		
		if (empty($time_period)) {
			trigger_error('ERROR - $time_period cannot be blank.', E_USER_ERROR);
		}
		
		$date_time_now = date('Y-m-d H:i:s');
		//dbug($date_time_now,'date_time_now');

		$date_time_past = date_create($date_time_now);
		//dbug($date_time_past,'$date_time_past');
		
		date_sub($date_time_past, date_interval_create_from_date_string($time_period));
		$date_past = date_format($date_time_past,"Y-m-d H:i:s");
		
		//dbug($date_past,'$date_past');

		return $date_past;
	
	}
	
	
	/*
	* Converts a string with characters like % and + to a clean numerical float value
	* eg +4.2% is converted to 4.2
	*/
	public static function stringToFloat($var) {
		
		// spaces seem to screw things up, so remove them
		$var = str_replace(' ', '', $var);
		$var = str_replace('"', '', $var);
		$var = floatval($var);
		
		return $var;
		
	}



	/**
	* Run a db query like SELECT or UPDATE
	* @param string $sql
	*/
	public function doQuery($sql) 
	{
		
		$result = self::$mysqli->query($sql);
		if($result === false) {
			// Handle failure - log the error, notify administrator, etc.
			return false;
		}
		else {
			// We successfully inserted a row into the database
			return $result;
		}
	}
	
	
	/*
	* returns the last mysql error
	*/
	public function getError(){
		
		return self::$mysqli->error;
	}
	
	
	/*
	* returns the last mysql error
	* used in common_functions.php
	*/
	public static function getErrorStatic(){
		
		return self::$mysqli->error;
	}
	
    
    /*
    * Gets errors nicely without trigger_erroring
    * allows us to return error to user in a more friendly fashion
    * param bool $setting - set to either true or false
    */
    public function setReturnNiceError($setting) {
        $this->return_nice_error = $setting;
    }
    
    
	
	/**
	* Method to return an array with multi rows
	* @param string $sql
	* @returns null or array with records
	*/
	public function getRows($sql)
	{
		
		$result = self::$mysqli->query($sql);
		$rows = null;
		
		// break on error
		if (self::$mysqli->error)
		{
            
            // are we returning a nice error or dying harshly?
            if ($this->return_nice_error) {
                // die nicely
                return null;
            }
            else {
                // die harshly
                trigger_error('getRows() mysqli error: '.self::$mysqli->error.'<br>$sql: <br>'.$sql, E_USER_ERROR);
                exit;
            }
		}
		
		// if results
		if ($result and $result->num_rows > 0){
			$rows = array();
			
			 // Cycle through results
			while ($row = $result->fetch_assoc()){
				$rows[] = $row;
			}
		}
		return $rows;
	}
	
	/*
	* Returns all the fields in a specific table
	*/
	public function getFields($table_name)
	{
		$sql = "SHOW COLUMNS FROM $table_name";
		//dbug($sql,'sql');
		
		$results = self::getRows($sql);
		
		//dbug($results,'$results','blue');
		$fields = null;
		foreach ($results as $key => $result) {
			$fields[] = $result['Field'];
		}
		
		//dbug($fields,'$fields');
		return $fields;
	}
	
	
	/**
	* Method to returns an array with single row
	* @param string $sql
	* @returns null or array with record
	*/
	public function getRow($sql)
	{
		//dbug($sql, 'sql', 'green');
		// apennd LIMIT to the supplied SQL
		$sql .= "
		LIMIT 1";
		
		//dbug($sql, 'sql', 'orange');
		
		$result = self::$mysqli->query($sql);
		$row = null;
		
		// break on error
		if (self::$mysqli->error)
		{
			echo 'getRows() mysqli error: '.self::$mysqli->error.'<br>$sql: <br>'.$sql;
			exit;
		}
		
		// if result
		if ($result and $result->num_rows > 0){
			
			$row = $result->fetch_assoc();
		}
		return $row;
	}
	
	
	/*
	* gets an individual field only
	* returns rows in a flat 1d array
	*/
	public function getField($sql, $field)
	{
		$results = self::getRows($sql);
		
		$out = array();
		
		foreach ($results as $key => $row) {
			$out[] = $row[$field];
		}
		
		return $out;
	}

	
	
	// get the auto id of the last inserted row
	public function getLastID() {
		return self::$mysqli->insert_id;
	}
	
	
	// Returns the number of rows affected by the last INSERT, UPDATE, REPLACE or DELETE query.
	// http://au2.php.net/manual/en/mysqli.affected-rows.php
	public function getAffectedRows() {
	
		return self::$mysqli->affected_rows;
	}
	
	
	// Returns a human readable date in the format of:
	// 2019-01-30 14:05:58
	// This is usually just used to print on the screen or log file eg using flushOutput()
	public function getHumanReadableDate() {
	
		return date('Y-m-d H:i:s');
	}
	
	// destructor
	public function __destruct()
	{
		self::$mysqli->close();
	}
	
	
	/**
	* Takes a Yahoo shorthand number eg 52.60M
	* and converts it into its true numerical value eg 52600000
	* Supports millions and billions
	* Good conversion tool to check numbers here:
	* http://www.endmemo.com/sconvert/onemillion.php
	*/
	public function stripNumberShorthand($string) {
		
		// determine if string contains M or B
		if (stristr($string, 'M') !== false) {
			
			// multiply by a million
			$multiplier = 1000000;
			
		}
		else if (stristr($string, 'B') !== false) {
			
			// multiply by a billion
			$multiplier = 1000000000;
			
		}
		else {
			// no match
			return $string;
		}
		
		
		// floatval() strips out the M and B characters
		$num = floatval($string);
		
		// multiply to get the full number
		$num = $num * $multiplier;
		
		return $num;
	}
	
	
	/**
	* This method does the reverse of stripNumberShorthand()
	*
	* It takes a long number 52 000 000
	* and converts it into a shorthand version eg 52 M
	* Supports millions and billions
	*
	*/
	public static function addNumberShorthand($number) {
		
		// do nothing if number is not numeric eg 0 or blank
		if (!is_numeric($number)) {
			return $number;
		}
		
		// if length in billions
		if ($number > 1000000000)
		{
			$new_number = $number / 1000000000;
			$new_number = round($new_number, 2);
			$new_number .= ' Billion';
		}
		else {
			// must be in the millions
			$new_number = $number / 1000000;
			$new_number = round($new_number, 2);
			$new_number .= ' Million';
		}
		
		return $new_number;
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
	* Gets the percentage difference between two values
	* @param int $value1
	* @param int $value2
	* @returns int percentage rounded to two decimal places
	*/
	public function getPercentageDifference($value1, $value2) {
		
		// safety check to prevent dividing by zero
		if ($value1 == 0 OR $value2 == 0) {
			return 0;
		}
		
		$percentage = (($value1 / $value2) * 100) - 100;
		//$percentage = $percentage * -1;
		
		$percentage = number_format($percentage, 2);
		//dbug($percentage,'percentage');
		return $percentage;
		
	}
	
}
?>