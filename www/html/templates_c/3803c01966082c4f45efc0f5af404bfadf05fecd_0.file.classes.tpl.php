<?php
/* Smarty version 3.1.30-dev/47, created on 2021-08-26 17:21:26
  from "/var/www/html/templates/classes.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/47',
  'unifunc' => 'content_612740f6e2b145_74549787',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3803c01966082c4f45efc0f5af404bfadf05fecd' => 
    array (
      0 => '/var/www/html/templates/classes.tpl',
      1 => 1624099829,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_612740f6e2b145_74549787 (Smarty_Internal_Template $_smarty_tpl) {
?>


<form method="POST" action="classes.php">

    <!-- About Section -->
    <section class="generic">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>SETUP CLASSES</h1>
                    <hr class="star-primary">
					Use the tables below to create and manage classes.
					<br />
					<br />
					Then use the <a href="students.php">Students page</a> to assign students to your classes.
					<br />
					<br />
					Classes can be disabled to prevent certain students accessing cars if another class (group) needs to use them.
					<br />This can help reduce conflicts when you have multiple tracks/servers running within the same physical room and within Bluetooth range of eachother.
					<br />
					<br />
					<br />
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 text-center">
					<h2>Classes</h2>
					<br />
					<table width="100%" class="general small_text">
						<tr>
							<th>class_id</th>
							<th>Class Name</th>
							<th>Description</th>
							<th>Students</th>
							<th>Cars Used</th>
							<th>Last Modified</th>
							<th>Active?</th>
							<th style="width: 130px;">Action</th>
						</tr>
					<?php if ($_smarty_tpl->tpl_vars['classes']->value) {?>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['classes']->value, 'row', false, 'i');
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
$__foreach_row_0_saved = $_smarty_tpl->tpl_vars['row'];
?>	
							<tr>
								<td><?php echo $_smarty_tpl->tpl_vars['row']->value['class_id'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['row']->value['description'];?>
</td>
								<td>
								
								<?php if ($_smarty_tpl->tpl_vars['row']->value['students']) {?>
									<table width="100%" class="small_table">
										<tr>
											<th>student_id</th>
											<th>Username</th>
										</tr>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['row']->value['students'], 'student', false, 'i');
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['student']->value) {
$_smarty_tpl->tpl_vars['student']->_loop = true;
$__foreach_student_1_saved = $_smarty_tpl->tpl_vars['student'];
?>
										<tr>
											<td><?php echo $_smarty_tpl->tpl_vars['student']->value['student_id'];?>
</td>
											<td><?php echo $_smarty_tpl->tpl_vars['student']->value['username'];?>
</td>
										</tr>
									<?php
$_smarty_tpl->tpl_vars['student'] = $__foreach_student_1_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
										<tr>
											<td></td>
											<td><strong><?php echo count($_smarty_tpl->tpl_vars['row']->value['students']);?>
 total</strong></td>
										</tr>
									</table>
									<br />
								<?php } else { ?>
									<em class="red">None</em>
								<?php }?>
								</td>
								<td>
								
								<?php if ($_smarty_tpl->tpl_vars['row']->value['cars']) {?>
									<table width="100%" class="small_table">
										<tr>
											<th>car_id</th>
											<th>Type</th>
											<th>MAC Address</th>
										</tr>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['row']->value['cars'], 'car', false, 'i');
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['car']->value) {
$_smarty_tpl->tpl_vars['car']->_loop = true;
$__foreach_car_2_saved = $_smarty_tpl->tpl_vars['car'];
?>
										<tr>
											<td><?php echo $_smarty_tpl->tpl_vars['car']->value['car_id'];?>
</td>
											<td><img src="/img/anki_icons/<?php echo $_smarty_tpl->tpl_vars['car']->value['type'];?>
.webp" width="50" /></td>
											<td><?php echo $_smarty_tpl->tpl_vars['car']->value['mac_address'];?>
</td>
										</tr>
									<?php
$_smarty_tpl->tpl_vars['car'] = $__foreach_car_2_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
									</table>
								<?php } else { ?>
									<em class="red">None</em>
								<?php }?>
								</td>
								<td><?php echo $_smarty_tpl->tpl_vars['row']->value['modified'];?>
</td>
								<?php if (($_smarty_tpl->tpl_vars['row']->value['active'])) {?>
									<td class="active">YES</td>
								<?php } else { ?>
									<td class="inactive">NO</td>
								<?php }?>
								<td>
									<a href="classes_edit.php?class_id=<?php echo $_smarty_tpl->tpl_vars['row']->value['class_id'];?>
" class="button_link" id="edit_car_button" title="edit class <?php echo $_smarty_tpl->tpl_vars['row']->value['class_id'];?>
"><span class="glyphicon glyphicon-edit"></span></a>
									<a href="classes_delete.php?class_id=<?php echo $_smarty_tpl->tpl_vars['row']->value['class_id'];?>
" class="button_link delete_class_button" title="delete class <?php echo $_smarty_tpl->tpl_vars['row']->value['class_id'];?>
"><span class="glyphicon glyphicon-trash"></span></a>
								</td>
							</tr>
						<?php
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_0_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
					<?php } else { ?>
						<tr>
							<td colspan="8"><em>Currently there are no existing classes in the database. Use the form below to create a new class.</em></td>
						</tr>
					<?php }?>
						
					</table>
					<br />
					<br />
					<hr>
					<br />
					<h2>Create a new Class</h2>
					<br />
					<span class="required">* required field</span>
					<br />
					<br />
					<table width="50%" class="general">
						<tr>
							<th>Class Name <span class="required">*</span>
								<br />
								<span class="explanatory_text">e.g. Year 8A</span>
							</th>
							<th>Description
								<br />
								<span class="explanatory_text">e.g. Mr Smith's 2021 Year 8A class</span>
							</th>
						</tr>
						<tr>
							<td><input type="text" name="class_name" style="width: 200px" maxlength="50" required></td>
							<td><input type="text" name="description" style="width: 300px" maxlength="100"></td>
						</tr>
					</table>
					<br />
					<br />
					<input type="submit" value="Save">&nbsp;&nbsp;&nbsp;
					<input type="button" value="Cancel" class="generic_button" title="/classes.php">
					
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
