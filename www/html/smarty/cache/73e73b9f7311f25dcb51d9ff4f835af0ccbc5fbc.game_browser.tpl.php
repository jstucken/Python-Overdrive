<?php
/* Smarty version 3.1.30-dev/47, created on 2016-02-23 09:19:37
  from "C:\htdocs\The Fall of the Wehrmacht\iwpserver\htdocs\templates\game_browser.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/47',
  'unifunc' => 'content_56cc1619a49a34_85862878',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '403b1a0d7e9cd8f7b1fdcc671cc58eb9bd3fe1e2' => 
    array (
      0 => 'C:\\htdocs\\The Fall of the Wehrmacht\\iwpserver\\htdocs\\templates\\game_browser.tpl',
      1 => 1456214926,
      2 => 'file',
    ),
  ),
  'cache_lifetime' => 120,
),true)) {
function content_56cc1619a49a34_85862878 (Smarty_Internal_Template $_smarty_tpl) {
?>
<script>
$('#game_browser').attr("value", 1);
</script>
Welcome <strong>Jono</strong>...

<nav>
  <ul class="nav nav-pills pull-right">
	<li role="presentation"><a href="#"><span class="glyphicon glyphicon-volume-off"></span> Create Game</a></li>
	<li role="presentation"><a href="logout.php"><span class="glyphicon glyphicon-volume-off"></span> Logout</a></li>
  </ul>
</nav>
<br>
<br>

<div id="game_browser">
	<h2>Available Games</h2>
</div><?php }
}
