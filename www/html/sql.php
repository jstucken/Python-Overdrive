<?php
require_once ('includes/site_config.php');
require_once ('includes/smarty_config.php');
require_once ('includes/header.php');

// this page allows the user to run their own SQL on the local DB
// user is prevented from running potentially destructive SQL eg DROP TABLE etc
$banned_words = array('INSERT', 'DELETE', 'DROP TABLE', 'CREATE TABLE', 'UPDATE', 'TRUNCATE', 'ALTER');
$permitted_words = array('SELECT');

// get fields in cars_data table to show user
$fields = $db->getfields('cars_data');
//dbug($fields,'fields');
$smarty->assign('fields', $fields);

//$select_results = $db->getRows($select_sql);
//dbug($select_results,'select_results');

if (empty($_POST['user_sql'])) {
	//echo "POST IS EMPTY";
	
}
else {
	// user has posted some data
	$errors = 0;
    
    // clear any prior SQL statement saved in session
    $_SESSION['sql']['user_sql'] = null;
    
	//dbug($_POST,'$_POST');
	//echo "POST HAS DATA";
	$user_sql = $_POST['user_sql'];
	
	// check user sql is ok
	foreach ($banned_words as $banned_word) {
		//dbug($banned_word,'banned_word');
		
		if(stristr($user_sql, $banned_word)) {
			
			$errors = 1;
			
			$error_msg = "Sorry, can't run your SQL because it contains the banned word '$banned_word'";
			
			$mysql_error = $error_msg;
		}
	}
	
	// SQL must be ok
	if ($errors == 0) {
        
        // die nicely if errors
        $db->setReturnNiceError(true);
        
        // run the user user_sql
		$results = $db->getRows($user_sql);
        
        //dbug($results,'$results');
        
        if (empty($results)) {
            echo "results empty";
        }
        
        // check for mysql errors
        $mysql_error = $db->getError();
        
        if ($mysql_error) {
            // return error message to the user
            //setStatusMessage('MYSQL ERROR: '. $mysql_error);
            //loadPage('/sql.php');
            //exit;
        }
        else {
            // all must be ok with query
            // get user fields from the results
            //dbug($results[0],'$results');
            
            // clear any cached error messages
            //clearStatusMessage();
            
            $_SESSION['sql']['user_sql'] = $user_sql;
            
            $user_fields = null;
            if (!empty($results[0])) {
                foreach($results[0] as $field => $value) {
                    $user_fields[] = $field;
                }
            }
        }
	}
	
	//dbug($user_fields,'$user_fields');
	$smarty->assign('results', $results);
	$smarty->assign('results_count', count($results));
	$smarty->assign('user_fields', $user_fields);
	$smarty->assign('user_sql', $_POST['user_sql']);
}

$smarty->assign('banned_words', $banned_words);
$smarty->assign('mysql_error', $mysql_error);
$smarty->assign('template', getPageTemplate());
$smarty->display('default.tpl');
//dbug($results,'$results');

//dbug($_SESSION,'$_SESSION');
?>