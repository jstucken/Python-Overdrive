<?php
/* Smarty version 3.1.30-dev/47, created on 2016-02-24 07:51:29
  from "C:\htdocs\The Fall of the Wehrmacht\iwpserver\htdocs\templates\login.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/47',
  'unifunc' => 'content_56cd52f122ce27_83616534',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e400d3f2fa86477a88dceaf820766770ede93df0' => 
    array (
      0 => 'C:\\htdocs\\The Fall of the Wehrmacht\\iwpserver\\htdocs\\templates\\login.tpl',
      1 => 1456296687,
      2 => 'file',
    ),
  ),
  'cache_lifetime' => 120,
),true)) {
function content_56cd52f122ce27_83616534 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="/img/favicon2.png" type="image/png">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/css/jumbotron-narrow.css">
<link rel="stylesheet" href="/css/style.css">

<script src="/js/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/soundManager2/soundmanager2-nodebug-jsmin.js"></script>
<script src="/js/scripts.js"></script>
<!--<script src="js/soundManager2/soundmanager2.js"></script>-->

<style>
body {
	background-color: transparent;
}
</style>

</head>

<body>


	<form class="form-horizontal" action="login.php" method="POST">
		<h3>Login</h3>
		<p>Choose your nickname which will identify you ingame.</p>

		<div class="row">
			<div class="col-xs-8">
				<input type="text" name="nickname" class="form-control" placeholder="Enter your nickname" required>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-md-2">
				<br>
			</div>
			<div class="col-xs-10 col-md-4">
				<button type="submit" class="btn btn-primary">Login</button>
			</div>
		</div>
	</form>
	

</body>
</html><?php }
}
