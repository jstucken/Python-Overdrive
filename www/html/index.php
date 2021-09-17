<?php
require_once ('includes/site_config.php');

require_once ('includes/smarty_config.php');
require_once ('includes/header.php');

// get version of this DET Python Anki Overdrive codebase/library
// eg: 1.1
$command = SHELL_SCRIPTS_PATH."get_version.sh";
$version = run_command($command);	// get the returned output from this command

// get server statistics
// get ip address of this machine to display to users
$command = SHELL_SCRIPTS_PATH."get_local_ip.sh";
$local_ip_address = run_command($command);	// get the returned output from this command

// local URL for students to access
$local_web_app_url = "http://$local_ip_address";

// Python scripts directory
$python_scripts_dir = PYTHON_SCRIPTS_PATH;

// Raspbian version
$command = SHELL_SCRIPTS_PATH."get_rasp_version.sh";
$rasp_version = run_command($command);	// get the returned output from this command

// Date
$command = SHELL_SCRIPTS_PATH."get_date.sh";
$date = run_command($command);	// get the returned output from this command

// Uptime
$command = SHELL_SCRIPTS_PATH."get_uptime.sh";
$uptime = run_command($command);	// get the returned output from this command

// Users connected
$command = SHELL_SCRIPTS_PATH."get_users_online.sh";
$users_connected = run_command($command);	// get the returned output from this command

// CPU Usage
$command = SHELL_SCRIPTS_PATH."get_cpu.sh";
$cpu_usage = run_command($command);	// get the returned output from this command

// Memory Usage
$command = SHELL_SCRIPTS_PATH."get_mem_usage.sh";
$memory_usage = run_command($command);	// get the returned output from this command

// Disk Usage
$command = SHELL_SCRIPTS_PATH."get_disk_usage.sh";
$disk_usage = run_command($command);	// get the returned output from this command


$smarty->assign('version', $version);
$smarty->assign('local_ip_address', $local_ip_address);
$smarty->assign('local_web_app_url', $local_web_app_url);
$smarty->assign('python_scripts_dir', $python_scripts_dir);
$smarty->assign('rasp_version', $rasp_version);
$smarty->assign('date', $date);
$smarty->assign('uptime', $uptime);
$smarty->assign('users_connected', $users_connected);
$smarty->assign('cpu_usage', $cpu_usage);
$smarty->assign('memory_usage', $memory_usage);
$smarty->assign('disk_usage', $disk_usage);


$smarty->assign('template', getPageTemplate());
$smarty->display('default.tpl');
//dbug($_SESSION,'$_SESSION','green');
?>