<?php

// show any error messages
if (isStatusMessage())
{
	//echo 'we have a message';
	$error_msg = getStatusMessage();
	
	//dbug($error_msg,'$error_msg');
	
	$smarty->assign('error_msg', $error_msg); 
	
	//debug($error_msg,'error_msg');
	//echo $error_msg;
}

?>