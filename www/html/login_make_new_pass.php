<html>
<body>
<?php
require_once ('includes/site_config.php');

/*
* Used by admin user to make a new hashed pass
* Locked down to only a designated admin IP address
*/
echo 'Your external IP: '.$_SERVER['REMOTE_ADDR'];

if ($_POST AND $_SERVER['REMOTE_ADDR'] == '999.999.999.999') {
//if ($_POST) {
	
	dbug($_POST,'$_POST');

	// make new hashed password now
	$user_pass = $db->makeDBSafe($_POST['password']);
	dbug($user_pass,'$user_pass');
	
	$hash = password_hash($user_pass, PASSWORD_DEFAULT);
	
	dbug($hash, 'hash', 'green');
	?>
	<textarea><?php echo $hash ?></textarea>
	<?php
	exit;
	
}

?>
</body>

<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
u: <input type="text" name="u">
p: <input type="text" name="p">
<br />
<input type="submit">
</form>
</html>