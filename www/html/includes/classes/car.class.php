<?php
/**
* Our car class
* handles GUI car related tasks
*/
class car
{
	//public $db_name;


	/*
	* Gets all the Anki cars in the database
	* returns multidimensional array of all cars
	*/
	public function getAllSavedCars() {
	
		// make a custom field (type_readable) which replaces underscores with spaces
		$select_sql = "
		SELECT
			car_id,
			mac_address,
			type,
			REPLACE(type, '_',' ') as type_readable,
			description,
			created,
			modified
		FROM cars ORDER BY car_id ASC";

		$saved_cars = db::getRows($select_sql);
		
		// make more user-friendly, readable car types by Title casing names
		foreach ($saved_cars as $key => $saved_car) {
			
			$type_readable = $saved_car['type_readable'];
			$type_readable = ucwords($type_readable);
			
			// save new variable into our results array
			$saved_cars[$key]['type_readable'] = $type_readable;
		}
				
		return $saved_cars;
	}
	
	
	/*
	* Gets all the cars used for a particular class
	* param int $class_id - the class id to search for
	* returns associative array containing all the cars
	*/
	public static function getCarsInClass($class_id) {
		
		if (empty($class_id) OR !is_numeric($class_id)) {
			trigger_error('Error - $class_id cannot be empty and must be numeric', E_USER_ERROR);
		}
		
		// array to hold our final list of cars
		$class_car_ids = array();
		
		// get class cars from DB
		$select_sql = "
		SELECT
			s.class_id,
			sc.student_id,
			sc.car_id
		FROM students_cars sc
		LEFT JOIN students s ON (sc.student_id = s.student_id)
		WHERE s.class_id='$class_id'
		ORDER BY sc.car_id ASC";

		$cars = db::getRows($select_sql);
		
		// loop through results and ensure no duplicates
		foreach ($cars as $car) {
			$car_id = $car['car_id'];
			
			// add to our final array, if not already in it
			if (!in_array($car_id,$class_car_ids)) {
				$class_car_ids[] = $car_id;
			}
		}
		
		// our final data containing info about each car, no duplicates
		$cars_data = array();
		
		foreach ($class_car_ids as $car_id) {
			$car = self::getCar($car_id);
			$cars_data[] = $car;
		}
		
		return $cars_data;
	}
	
	
	/*
	* Gets all data for a particular car
	* param int $car_id - the car_id you want
	* returns assoc array with car data
	*/
	public static function getCar($car_id) {
		
		if (empty($car_id) OR !is_numeric($car_id)) {
			trigger_error('Error - $car_id cannot be empty and must be numeric', E_USER_ERROR);
		}
		
		// get car data
		$select_sql = "SELECT * FROM cars WHERE car_id='$car_id'";
		$car_data = db::getRow($select_sql);
		
		return $car_data;
		
	}
	
}
?>