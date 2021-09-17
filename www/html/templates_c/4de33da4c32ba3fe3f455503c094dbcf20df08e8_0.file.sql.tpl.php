<?php
/* Smarty version 3.1.30-dev/47, created on 2021-08-26 17:18:13
  from "/var/www/html/templates/sql.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/47',
  'unifunc' => 'content_61274035ed6880_76623903',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4de33da4c32ba3fe3f455503c094dbcf20df08e8' => 
    array (
      0 => '/var/www/html/templates/sql.tpl',
      1 => 1624085152,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_61274035ed6880_76623903 (Smarty_Internal_Template $_smarty_tpl) {
?>


<form method="POST" action="sql.php#run_sql" id="sql_form">
	
    <!-- About Section -->
    <section class="generic">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>SQL EDITOR</h1>
                    <hr class="star-primary">
					<br />
					<br />
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 text-center large_text">
					<br />
					<strong>Run some custom SQL of your choosing on the local database.</strong>
					<br />
					<br />
					The following SQL commands are not permitted:
					<br />
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['banned_words']->value, 'word', false, 'i');
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['word']->value) {
$_smarty_tpl->tpl_vars['word']->_loop = true;
$__foreach_word_0_saved = $_smarty_tpl->tpl_vars['word'];
?>
						<?php echo $_smarty_tpl->tpl_vars['word']->value;?>
<br />
					<?php
$_smarty_tpl->tpl_vars['word'] = $__foreach_word_0_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
						
					<br />
					<br />
					<strong>Examples:</strong>
					<br />
					<br />
					<table width="70%" class="general">
						<tr>
							<th>Example 1 - Get everything from the cars_data table</th>
							<th>Example 2 - See all fields in the cars_data table</th>
							<th>Example 3 - Show all tables in the database</th>
						</tr>
						<tr>
							<td>SELECT * FROM cars_data</td>
							<td>SHOW COLUMNS FROM cars_data</td>
							<td>SHOW TABLES</td>
						</tr>
					</table>
                    <a name="run_sql"></a>
					<br />
					<br />
					<strong>YOUR SQL:</strong>
					<br />
					<br />
					<table width="70%" class="general">
						<tr>
							<th>YOUR SQL:</th>
						</tr>
						<tr>
							<td><textarea name="user_sql" id="user_sql" class="user_sql" placeholder="Enter your SQL here..." style="min-height: 100px"><?php echo $_smarty_tpl->tpl_vars['user_sql']->value;?>
</textarea></td>
						</tr>
						
					</table>
					<br />
					<a href="#run_sql" class="button_link form_submit"><span class="glyphicon glyphicon-play"></span>&nbsp;&nbsp;Run SQL</a> 
					
					<br />
					<br />
					<?php if ($_smarty_tpl->tpl_vars['mysql_error']->value) {?>
                        <div style="color: red; font-weight: bold; font-size: 26px">MYSQL ERROR: <?php echo $_smarty_tpl->tpl_vars['mysql_error']->value;?>
</div>
                        <br />
                    <?php }?>
                    <hr>
					<h2><?php echo $_smarty_tpl->tpl_vars['results_count']->value;?>
 RESULTS</h2>
					<br />
                    <?php if ($_smarty_tpl->tpl_vars['results']->value) {?>
                        <div>
                            <a href="/sql_export_csv.php" class="button_link"><span class="glyphicon glyphicon-floppy-save"></span>&nbsp;&nbsp;Export CSV</a>
                        </div>
                    <?php }?>
					<!-- SHOW DB fields -->
                    <br />
					<table width="90%" class="general">
						<tr>
							
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['user_fields']->value, 'field', false, 'c');
foreach ($_from as $_smarty_tpl->tpl_vars['c']->value => $_smarty_tpl->tpl_vars['field']->value) {
$_smarty_tpl->tpl_vars['field']->_loop = true;
$__foreach_field_1_saved = $_smarty_tpl->tpl_vars['field'];
?>
							<th><?php echo $_smarty_tpl->tpl_vars['field']->value;?>
</th>
						<?php
$_smarty_tpl->tpl_vars['field'] = $__foreach_field_1_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
						</tr>
					
						<?php if ($_smarty_tpl->tpl_vars['results']->value) {?>
							
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['results']->value, 'result', false, 'i');
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['result']->value) {
$_smarty_tpl->tpl_vars['result']->_loop = true;
$__foreach_result_2_saved = $_smarty_tpl->tpl_vars['result'];
?>	
								<tr>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['user_fields']->value, 'field', false, 'col_id');
foreach ($_from as $_smarty_tpl->tpl_vars['col_id']->value => $_smarty_tpl->tpl_vars['field']->value) {
$_smarty_tpl->tpl_vars['field']->_loop = true;
$__foreach_field_3_saved = $_smarty_tpl->tpl_vars['field'];
?>
									<td><?php echo $_smarty_tpl->tpl_vars['result']->value[$_smarty_tpl->tpl_vars['field']->value];?>
</td>
								<?php
$_smarty_tpl->tpl_vars['field'] = $__foreach_field_3_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
								</tr>
							<?php
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_2_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
						<?php } else { ?>
							Your query returned no results
						<?php }?>
						
					</table>
					
				</div>
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <!--<a href="#" class="btn btn-lg btn-outline">
                        <i class="fa fa-download"></i> Download Theme
                    </a>-->
                </div>
            </div>

        </div>
    </section>
	
</form>
	
	
	<?php }
}
