<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/site_config.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/smarty_config.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/classes/car.class.php');

// ensure only admin users (teachers) can access this page
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/admin_login_check.php');

// instantiate our car class
$c = new car();

// set how long to scan for available cars (in seconds)
$scan_duration = 1;

// get all saved cars in DB
$saved_cars = $c->getAllSavedCars();


//dbug($saved_cars,'saved_cars');

// make a simple 1D array containing just the saved car mac addresses
// this can be quickly searched to see if a particular car has been saved or not
$saved_cars_macs = array();

if (!empty($saved_cars)) {
	foreach ($saved_cars as $car) {
		$saved_cars_macs[] = $car['mac_address'];
	}
}

//dbug($saved_cars_macs,'saved_cars_macs');

// Scan for nearby Anki bluetooth cars
// Do this by issuing CLI commands through PHP
// GOOD READ!
// https://reverse-engineering-ble-devices.readthedocs.io/en/latest/script_creation/00_script_creation.html

// see also getting car model from:
// https://anki.github.io/drive-sdk/docs/programming-guide

// how to use C based anki SDK vehicle-tool
// https://github.com/anki/drive-sdk/wiki/Getting-Started-on-Ubuntu

// use this command to scan quick:
// sudo hcitool lescan
// https://stackoverflow.com/questions/32300008/scan-bluetooth-low-energy-using-hcitool

// find all nearby Low Energy (LE) bluetooth devices
$command = 'sudo timeout -s SIGINT '.$scan_duration.'s hcitool lescan';
//dbug($command,'$command','green');
	
$output = run_command($command);
//dbug($output,'$output');

// split results into an array, one line at at time
$lines = explode("\n", $output);
//dbug($lines,'$lines');

// whitelist to hold NEW available Anki cars from the scan
$scanned_cars_new = array();

// this array holds ALL available Anki cars from the scan
$scanned_cars_all = array();


// loop through the array and find Anki Overdrive cars only
foreach ($lines as $key => $line) {
    //dbug($line,'$line','green');
    
    // Anki cars contain 'Drive' in their bluetooth id
    $pos = strpos($line, 'Drive');
    
    // we have an Ank
    if ($pos !== false) {
        //echo 'we found an Anki car on line: '.$key;
        
        // strip out just the MAC address
        $parts = explode(' ',$line);
        //dbug($parts,'$parts');
        $mac_address = $parts[0];
        
        // add to our whitelist of available cars
		// but only if it's not already saved in the DB
		if (!in_array($mac_address, $saved_cars_macs)) {
			$scanned_cars_new[] = $mac_address;
		}
		
		// add mac address to all list
		$scanned_cars_all[] = $mac_address;
    }
}

// sort the array into alphabetical order by Mac Address
sort($scanned_cars_new);
sort($scanned_cars_all);

//dbug($scanned_cars_new,'$scanned_cars_new','blue');
//dbug($scanned_cars_all,'$scanned_cars_all','black');
//exit;

$smarty->assign('saved_cars', $saved_cars);
$smarty->assign('saved_cars_macs', $saved_cars_macs);
$smarty->assign('scanned_cars_new', $scanned_cars_new);
$smarty->assign('scanned_cars_all', $scanned_cars_all);
$smarty->assign('template', getPageTemplate());
$smarty->display('default.tpl');
?>