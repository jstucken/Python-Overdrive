<?php
session_start();
require_once ('includes/site_config.php');
require_once ('includes/smarty_config.php');

// clear session data
// we dont call session_destroy() as logout message is still passed via session
unset($_SESSION['user']);
unset($_SESSION['report']);
unset($_SESSION['word']);
unset($_SESSION['student']);
unset($_SESSION['login_attempts']);
unset($_SESSION['import']);

setStatusMessage('You have successfully logged out', false);
loadPage('/index.php');
?>