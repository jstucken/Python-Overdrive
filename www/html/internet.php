<?php
require_once ('includes/site_config.php');
require_once ('includes/smarty_config.php');
require_once ('includes/header.php');

// ensure only admin users (teachers) can access this page
require_once ('includes/admin_login_check.php');

// get ip address of this machine to display to users
$command = SHELL_SCRIPTS_PATH."get_local_ip.sh";
$local_ip_address = run_command($command);	// get the returned output from this command


$smarty->assign('local_ip_address', $local_ip_address);
$smarty->assign('template', getPageTemplate());
$smarty->display('default.tpl');
?>