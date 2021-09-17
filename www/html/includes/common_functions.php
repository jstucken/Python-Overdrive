<?php
/**
* @desc function to debug variables, arrays, multi-dimensional arrays, SQL or anything really
* @param mixed $variable item to debug
* @param string $label (optional) a friendly description to explain what you are debugging
* @param string $color (optional) css text color to color the debugging info.
*/
function dbug($variable, $label='', $color='red')
{
	// Get backtrace data so we can determine what called this function
	// Work out the last file/line which called this function
	$backtrace = debug_backtrace();
	$key = 0;
	$file = basename($backtrace[$key]['file']);
	$line = $backtrace[$key]['line'];
	
	$debug_data = '
	<br />
	<span style="color: '.$color.'"><strong>Debug</strong>';
	if ($label !='')
	{
		$debug_data .= ' '.$label;
	}
	$debug_data .= ' <i style="font-size: 10px">('.$file.' line '.$line.')</i>';
	$debug_data .= '</span>
	<br />';

	$debug_data .= '<pre style="color: '.$color.'; font-style: italic; font-weight: bold; width: 700px; border: 1px dashed '.$color.'; padding: 10px; margin: 10px">'.htmlentities(print_r($variable, TRUE)).'</pre>';
	$debug_data .= '
	<br />
	<br />';
	
	echo $debug_data;
}


/**
* @desc function to debug variables, arrays, multi-dimensional arrays, SQL or anything really
* @param mixed $variable item to debug
* @param string $label (optional) a friendly description to explain what you are debugging
* @param string $color (optional) css text color to color the debugging info.
*/
function debug($variable, $label='', $color='red')
{
	// Get backtrace data so we can determine what called this function
	// Work out the last file/line which called this function
	$backtrace = debug_backtrace();
	$key = 0;
	$file = basename($backtrace[$key]['file']);
	$line = $backtrace[$key]['line'];
	
	$debug_data = '
	<br />
	<span style="color: '.$color.'"><strong>Debug</strong>';
	if ($label !='')
	{
		$debug_data .= ' '.$label;
	}
	$debug_data .= ' <i style="font-size: 10px">('.$file.' line '.$line.')</i>';
	$debug_data .= '</span>
	<br />';

	$debug_data .= '<pre style="color: '.$color.'; font-style: italic; font-weight: bold; width: 700px; border: 1px dashed '.$color.'; padding: 10px; margin: 10px">'.htmlentities(print_r($variable, TRUE)).'</pre>';
	$debug_data .= '
	<br />
	<br />';
	
	echo $debug_data;
}


/*
* Returns a date time string formatted like 
* 2021-02-10 04:13:15
*/
function getDateTime() {
	$date_time = date('Y-m-d H:i:s');
	
	return $date_time;
}


/*
* Returns a date time string formatted like 
* 2021-02-10 04:13:15
*/
function getDateTimeMicro() {
	$date_time = date('Y-m-d H:i:s');
	
	// with microseconds
	$micro_date = microtime();
	//dbug($micro_date,'$micro_date');
	
	$date_array = explode(" ",$micro_date);	
	//dbug($date_array,'date_array');
	
	$micro_bit = $date_array[0];
	//dbug($micro_bit,'$micro_bit');
	
	// round off to two decimal places
	$micro_bit = number_format($micro_bit, 2, '.', '');
	//dbug($micro_bit,'$micro_bit','green');
	
	// strip the leading 0 off the microseconds
	$pieces = explode(".", $micro_bit);
	$micro_bit = '.'.$pieces[1];
	
	$date = date("Y-m-d H:i:s",$date_array[1]);
	
	$date_time_micro = $date.$micro_bit;
	
	//dbug($date_time_micro,'$date_time_micro');
	return $date_time_micro;
}



/**
* Loads a new page
*/
function loadPage($url) {
	//var_dump(headers_list());
	

	// check if headers already sent or not
	if(headers_sent()) {
		// fallback to using javascript
		echo '<html>';
		//echo '<script>';
		//echo 'window.location.href = "'.$url.'"';
		echo 'Click <a href="'.$url.'">here</a> if you are not automatically redirected';
		//echo '<script>';
		echo '</html>';
	}
	else {
		//echo 'Headers not sent';
		header("Location:$url");
    }

	exit();
	
}



/**
* @desc Sets an status in the session to pass it between pages and display to user
* @param mixed $message Containg message
* @param bool $is_error Specify if this is an error message or not
*/
function setStatusMessage($message, $is_error = true)
{
	if (!is_bool($is_error))
	{
		trigger_error('Error - setStatusMessage: $is_error must be either true or false.', E_USER_ERROR);
	}
	
	if (isset($_SESSION))
	{
		$_SESSION['status'] = array(
			'status_message' => $message,
			'is_error' => $is_error
		);
	}
}


/**
* @desc Checks if there is a status message present
* Useful to check if there are messages before attempting to display them
* @return bool Returns true on error, false on no error
*/
function isStatusMessage()
{
	if (isset($_SESSION) && !empty($_SESSION['status']['status_message']))
	{
		return true;
	}
	else
	{
		return false;
	}
}


/**
* @desc Gets status message from the session if available
* then clears from session so new messages may be tracked.
* @return mixed Returns string containing message if present or null if not
*/
function getStatusMessage()
{
	$message = null;
	if (isset($_SESSION) && !empty($_SESSION['status']['status_message']))
	{
		$message = $_SESSION['status']['status_message'];
		
		// format message
		if ($_SESSION['status']['is_error'])
		{
			$css_class = 'alert alert-danger';
		}
		else
		{
			$css_class = 'alert alert-success';
		}
		//$message = '<div class="'.$css_class.'">'.$message.'</div>';
		$message = '<div class="'.$css_class.' col-md-8">'.$message.'</div>';
	}
	
	clearStatusMessage();
	return $message;
}


/**
* @desc Clears any existing error_message in the session
*/
function clearStatusMessage()
{
	if (isset($_SESSION))
	{
		unset($_SESSION['status']);
	}
}



/**
*@desc Our custom error handling function.
* Handles errors and stops running the script on error if its an E_USER_ERROR
* @param int $error_no
* @param string $error_text
* @param string $error_file
* @param int $error_line
*/
function customErrorHandler($error_no, $error_text, $error_file, $error_line)
{
	// Generate a unique error number. This is a unix timestamp plus
	// a random number just for safety in case more than one person throws an error at
	// the exact same time/second
	$error_time = time();
	$error_rand = rand(1, 99);
	$error_id = $error_time.'_'.$error_rand;
	
	if (!strstr($error_text, 'Error - '))
	{
		$error_text = 'Error - '.$error_text;
	}
	
	// Compile backtrace data which is extremely useful for debugging
	$backtrace_data = debug_backtrace();
	unset($backtrace_data[0]); // this always contains customErrorHandler() data
	$backtrace_message = null;
	// debug($backtrace_data, '$backtrace_data');
	
	foreach ($backtrace_data as $key => $element)
	{
		if (!empty($element['file']))
		{
			if (empty($backtrace_message))
			{
				$backtrace_message = "Backtrace info: \n\n";
			}
			
			$backtrace_message .= "$key) ";
			$backtrace_message .= "{$element['file']} line {$element['line']}";
			
			// show which classes and functions were called
			if (!empty($element['function']))
			{
				$backtrace_message .= ', ';
				if (!empty($element['class']))
				{
					$backtrace_message .= "{$element['class']}::";
				}
				$backtrace_message .= "{$element['function']}()";
			}
			$backtrace_message .= ".\n";
		}
	}
    switch ($error_no)
    {
	    case E_USER_ERROR:

	        // Build error message that the user will see
			$user_message = '
			<div style="margin: 10px; padding: 10px; color: #444444; border: 1px solid #444444; font-family: Arial; font-size: 12px">
				<b style="font-size: 14px">Error ID: '.$error_id.'</b>
					<br>
					<br>
					<i>'.$error_text.'</i>
					<br>
					<br>
					If you require further assistance please contact the System Administrator and quote the Error ID above.
					<br>
					<br>
					'.nl2br($backtrace_message).'
			</div>
		';
            // Display the above error to the user
			echo $user_message;

            // Now build the error that will get logged on the server
			// Find out some details about this user

			$error_log_message = "error_id: ".$error_id."\n";
			$error_log_message .= "error_text: ".$error_text."\n";
			$error_log_message .= "\n$backtrace_message\n";
			$error_log_message .= "Date: ".date('h:i:sa d/m/Y', $error_time)."\n";
			$error_log_message .= "IP Address: ".getenv("REMOTE_ADDR")."\n";
			$error_log_message .= "Agent: ".$_SERVER['HTTP_USER_AGENT']."\n";
			
			// the following requires the db class to be instantiated
			if (db::getErrorStatic())
			{
				$error_log_message .= "mysqli_error: ".db::getErrorStatic()."\n\n";
			}
            /*
			$error_log_message .= "\n\nGLOBALS:\n";
			$error_log_message .= print_r($GLOBALS, TRUE);
			$error_log_message .= "===========================================";
			
			$error_log_message .= "\nRESULTS OF debug_backtrace():\n\n";
			$error_log_message .= print_r($backtrace_data, TRUE);

			//debug($error_log_message, 'error_log_message');
			
			// write all the above details to a log file on the server
			writeLogFile(ERROR_LOG_PATH, $error_time, $error_log_message, $error_rand.'_'.basename($error_file));
            */
		    exit;
		    break;

	    case E_USER_WARNING:
	        //echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
	        break;

	    case E_USER_NOTICE:
	        //echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
	        break;

	    default:
	        //echo "Unknown error type: [$errno] $errstr<br />\n";
	        break;
	}

	/* Don't execute PHP internal error handler */
	return true;
}



/**
* @desc creates an error log file on the server for the purpose of error tracking and debugging.
* @param string $log_path Must containg trailing slash (/)
* @param string $log_timestamp Unix Timestamp
* @param string $log_message Message containing details of error
* @param string $extra_filename_text (optional) Extra text to insert into the log filename.
*/
function writeLogFile($log_path, $log_timestamp, $log_message, $extra_filename_text = null)
{
	// We want to file the error log under years and months
	$year = date('Y', $log_timestamp);
	$month = date('M', $log_timestamp);
	
	// create current error log year dir if it dont exist already.
	// Directories must be chmod'ed correctly or else you wont be able to delete the files via FTP.
	//dbug($log_path.$year, '$log_path.$year');
	
	if (!file_exists($log_path.$year))
	{
		mkdir($log_path.$year);
		chmod($log_path.$year, 0777);
	}

	if (!file_exists($log_path.$year.'/'.$month))
	{
		mkdir($log_path.$year.'/'.$month);
		chmod($log_path.$year.'/'.$month, 0777);
	}
	
	if (empty($extra_filename_text))
	{
		$log_file = $log_path.$year.'/'.$month.'/'.$log_timestamp.'.log';
	}
	else
	{
		$log_file = $log_path.$year.'/'.$month.'/'.$log_timestamp.'_'.$extra_filename_text.'.log';
	}
	
	// create new log file and write to it
	$fp = fopen($log_file, 'w');
	fwrite($fp, $log_message);
	fclose($fp);
	chmod($log_file, 0777);
}


/**
* @desc Simple email function
* @param string $to
* @param string $subject
* @param string $message
*/
function sendEmail($to, $subject, $message, $html = true)
{
	$headers  = "MIME-Version: 1.0\r\n";
	
	/* To send HTML mail, you can set the Content-type header. */
	if ($html == true)
	{
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	}
	
	/* additional headers */
	//$headers .= "To: Mary <mary@example.com>, Kelly <kelly@example.com>\r\n";
	$headers .= "From: Stock Patrol Website <noreply@cowraweb.com.au>\r\n";
	//$headers .= "Bcc: ".ADMIN_EMAIL."\r\n";

	/* and now mail it */
	if (mail($to, $subject, $message, $headers))
	{
		return true;
	}
	else
	{
		return false;
	}
}


/**
* Gets the name of the page template
* This is used to automatically find the smarty template corresponding to the script name
* eg: /index.php is returned as index.tpl
* eg: /tools/subdir/index.php is returned as tools/subfolder/index.tpl
*/
function getPageTemplate() {
	
	$uri = $_SERVER['PHP_SELF'];
	
	//dbug($uri,'uri');
	
	$uri_pieces = explode('/', $uri);
	
	// pull the pagename from the last position in array
	$page_key = count($uri_pieces) -1;
	$page = $uri_pieces[$page_key];
	$page = str_replace('.php', '.tpl', $page);
		
	// pages residing in site root dir will only have two pieces in the array
	// subdirectories will have more
	// This code handles subdirectories
	if (count($uri_pieces) > 2) {
		
		// get rid of unneccesary junk from uri_pieces
		// we only want the folders/sub folders
		unset($uri_pieces[0]);		// usually nothing in position 0
		unset($uri_pieces[$page_key]);		// get rid of script name from last position of array
		
		
		// build path to our template file
		$path = null;
		foreach ($uri_pieces as $piece) {
			$path .= "$piece/";
		}
		
		$page = $path.$page;
		
		//dbug($uri_pieces,'uri_pieces','green');
		//dbug($path,'path','green');
		
	}
	
	return $page;
}



/**
* Returns the script execution time for any page
*/
function getExecutionTime() {
	// record script run time
	sleep(1);		//unsure why, but without this it seems inaccurate
	
	$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
	$time = round($time, 3);
	
	return $time;
	
}




/*
* Flush the output buffer onto the screen
* Useful to call in large import scripts after each row
* string $output contains whatever we need to print on the screen or linux console (CLI)
*/
function flushOutput($output) {
	
	// automatically make a new line after
	$output .= '<br>';

	// If this script is running from shell (eg manually or via CRON), convert html tags to shell safe equivalents
	if (SHELL) {
		$output = str_ireplace("<br>", "\n", $output);
		$output = str_ireplace("<br />", "\n", $output);
		$output = str_ireplace("<br/>", "\n", $output);
		
		// make nice shell <hr>'s :)
		$output = str_ireplace("<hr>", "###############################################################\n", $output);
		
		// strip out any other html tags eg <strong>
		$output = strip_tags($output);
	}
	
	echo $output;
	ob_end_flush();
	flush();
}


/*
* Pass a 1D array to get an average of all the values
*/
function average($arr)
{

   if (!is_array($arr)) return false;

   return array_sum($arr)/count($arr);
}


/*
* Function to run a shell command through PHP
* returns the output back to calling code
* Flushes the browser output so user can see progress on screen
* Does not output to screen, can be made to echo output loudly by passing $verbose=1
*/
function run_command($command, $verbose=false) {
	
	$output = shell_exec($command);
	
	// are we in quiet mode or not?
	if ($verbose) {
		
		echo $output.'<br>';
		
		// flush browser resolver cache so output gets displayed
		// on screen immediately before script is finished
		ob_end_flush();
		flush();
	}
	else {
		// must be in quiet mode
		return $output;
	}
}


?>