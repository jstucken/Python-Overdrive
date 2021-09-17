<?php
/* Smarty version 3.1.30-dev/47, created on 2021-08-26 17:18:09
  from "/var/www/html/templates/docs.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/47',
  'unifunc' => 'content_612740313c3821_11262878',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e6888b5a783680020b57b7feb11a6d65d9ab41b3' => 
    array (
      0 => '/var/www/html/templates/docs.tpl',
      1 => 1624240055,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_612740313c3821_11262878 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="docs_sidenav" class="sidenav">

<?php if ($_SESSION['user']) {?>
    <a href="#">Teachers</a>
    <ul>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['teacher_docs']->value, 'row', false, 'i');
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
$__foreach_row_0_saved = $_smarty_tpl->tpl_vars['row'];
?>	
        <li><a href="docs.php?doc_id=<?php echo $_smarty_tpl->tpl_vars['row']->value['doc_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</a></li>
    <?php
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_0_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
    </ul>
<?php }?>  

    <a href="#">Students</a>
    <ul>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['student_docs']->value, 'row', false, 'i');
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
$__foreach_row_1_saved = $_smarty_tpl->tpl_vars['row'];
?>
        <li><a href="docs.php?doc_id=<?php echo $_smarty_tpl->tpl_vars['row']->value['doc_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</a></li>
    <?php
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_1_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
    </ul>
    
    <a href="#">Overdrive Class Methods</a>
    <ul>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['overdrive_docs']->value, 'row', false, 'i');
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
$__foreach_row_2_saved = $_smarty_tpl->tpl_vars['row'];
?>
        <li><a href="docs.php?doc_id=<?php echo $_smarty_tpl->tpl_vars['row']->value['doc_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</a></li>
    <?php
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_2_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
    </ul>
</div>

<?php if ($_smarty_tpl->tpl_vars['doc_id']->value) {?>
    <div class="docs_main">
        <h1><?php echo $_smarty_tpl->tpl_vars['doc']->value['name'];?>
</h1>
        <br />
        <p><?php echo $_smarty_tpl->tpl_vars['doc']->value['content'];?>
</p>
        <br />
        <br />
        <br />
        <br />
    </div>
<?php } else { ?>
    <div class="docs_main">
        <h1>Documentation</h1>
        <br />
        <p>Use the links in the left side navigation to browse the docs.</p>
    </div>
<?php }?>

<?php }
}
