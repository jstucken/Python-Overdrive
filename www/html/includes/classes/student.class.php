<?php
/**
* Our Student class
* handles GUI student related tasks
*/
class student
{
	//public $db_name;

	/*
	* Gets all the Anki cars assigned to a student
	* param int $student_id - the id of the student
	* returns multidimensional array of cars linked to the student
	*/
	public function getStudentCars($student_id) {
	
		if (!is_numeric($student_id)) {
			trigger_error('Error - $student_id must be numeric', E_USER_ERROR);
		}
		
		// get cars linked to this student
		$cars_sql = "
		SELECT
			sc.car_id,
			c.mac_address AS car_mac_address,
			c.type AS car_type
		FROM students_cars sc
		LEFT JOIN cars c ON (c.car_id = sc.car_id)
		WHERE sc.student_id = '$student_id'
		";

		//dbug($cars_sql,'cars_sql');

		$cars = db::getRows($cars_sql);
		//dbug($cars,'$cars');
		
		return $cars;
	}
	
	
	/*
	* Same as getStudentCars() method above, but returns a flat 1D array of cars
	*/
	public function getStudentCarsFlat($student_id) {
		
		$cars = $this->getStudentCars($student_id);
		
		dbug($cars,'cars');
		exit;
	}
	
	/*
	* Checks whether a student has been assigned a particular car or not
	* param int $student_id - the student id to check
	* param int $car_id - the car id to check
	* returns true or false
	*/
	public function isCarAssignedToStudent($student_id, $car_id) {
		
		$student_id = db::makeDBSafe($student_id);
		$car_id = db::makeDBSafe($car_id);
		
		$select_sql = "SELECT id FROM students_cars WHERE student_id='$student_id' AND car_id='$car_id'";
		$select_result = db::getRow($select_sql);
		
		if (empty($select_result)) {
			return false;
		}
		else {
			return true;
		}
		
	}
	
	
	/*
	* select all data related to a specified student
	* returns an associative array containing student details including their classname and all their cars
	*/
	public function getStudent($student_id) {
	
		if (!is_numeric($student_id)) {
			trigger_error('Error - $student_id must be numeric', E_USER_ERROR);
		}
		
		// select all data for this student
		$student_sql = "
		SELECT
			s.*,
			c.name as class_name
		FROM students s
		LEFT JOIN classes c ON (c.class_id = s.class_id)
		WHERE s.student_id = '$student_id'";
		
		$student = db::getRow($student_sql);
		
		// get cars assigned to this student
		if (!empty($student)) {
			$student['cars'] = $this->getStudentCars($student_id);
		}
		
		//dbug($student,'student');
		
		return $student;
	}
	
	
	/*
	* select all students from students table
	* returns an associative array containing student details including their classname
	*/
	public function getAllStudents() {
	
		// select all students from students table
		$student_sql = "
		SELECT
			s.*,
			c.name as class_name,
			c.active as class_active
		FROM students s
		LEFT JOIN classes c ON (c.class_id = s.class_id)
		ORDER BY s.student_id ASC";
		
        //dbug($student_sql,'student_sql');
        
		$students = db::getRows($student_sql);
		
        //dbug($students,'students','black');
        
		// get cars assigned to each student
		foreach ($students as $key => $student) {
			$students[$key]['cars'] = $this->getStudentCars($student['student_id']);
		}
		
		//dbug($students,'$students','green');
		
		return $students;
	}
	
	
	/*
	* gets all students belonging to a specified class
	* param int $class_id - the class_id to fetch from
	* returns an associative array containing student details
	*/
	public function getStudentsInClass($class_id) {
		
		$class_id = db::makeDBSafe($class_id);
		
		if (empty($class_id) OR !is_numeric($class_id)) {
			trigger_error('Error - $class_id must not be empty and must be numeric', E_USER_ERROR);
		}
	
		// select students from students table for the specified class
		$student_sql = "
		SELECT
			s.*,
			c.name as class_name
		FROM students s
		LEFT JOIN classes c ON (c.class_id = s.class_id)
		WHERE s.class_id='$class_id'
		ORDER BY s.student_id ASC";
		
		$students = db::getRows($student_sql);
		
		//dbug($students,'$students','green');
		
		return $students;
	}
	
	
	/*
	* Gets all classes from DB
	* returns an associative array containing classes
	*/
	public function getAllClasses() {
		
		$classes_sql = "
		SELECT
			class_id,
			name,
			description,
			active,
			DATE_FORMAT(created, '".READABLE_DATE_FORMAT."') as created,
			DATE_FORMAT(modified, '".READABLE_DATE_FORMAT."') as modified
		FROM classes ORDER BY class_id ASC";
		
		//dbug($classes_sql,'classes_sql','green');
		
		$classes = db::getRows($classes_sql);
		
		return $classes;
	}
	
	
	/*
	* Gets all classes from DB with students attached in multidimensional array
	*/
	public function getAllClassesWithStudents()
	{
		$classes = $this->getAllClasses();
		
		// loop through our classes and append students
		foreach ($classes as $key => $class) {
			
			//dbug($class,'class');
			$class_id = $class['class_id'];
			
			// get all cars used in this class
			$class_cars = car::getCarsInClass($class_id);
			$classes[$key]['cars'] = $class_cars;
			
			//dbug($class_cars,'$class_cars','blue');
			
			$students = $this->getStudentsInClass($class_id);
			//dbug($students,'$students','brown');
			
			// add students into our classes array
			$classes[$key]['students'] = $students;
		}
		
		//debug($classes,'classes','black');
		
		return $classes;
		
	}
	
	
}
?>