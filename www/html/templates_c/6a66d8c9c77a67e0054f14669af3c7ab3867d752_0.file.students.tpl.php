<?php
/* Smarty version 3.1.30-dev/47, created on 2021-09-06 15:18:52
  from "/var/www/html/templates/students.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/47',
  'unifunc' => 'content_6135a4bc56d878_84644409',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6a66d8c9c77a67e0054f14669af3c7ab3867d752' => 
    array (
      0 => '/var/www/html/templates/students.tpl',
      1 => 1630905530,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6135a4bc56d878_84644409 (Smarty_Internal_Template $_smarty_tpl) {
?>


<form method="POST" action="students.php" id="add_student_form">

    <!-- About Section -->
    <section class="generic">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>SETUP STUDENTS</h1>
                    <hr class="star-primary">
					Teachers can use this page to add/remove students and assign Anki cars to them.
					<br />
					<br />
					Students can be <a href="classes.php">placed into classes</a> to assist with multiple track setups.
					<br />
					<br />
					<br />
					<br />
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 text-center">
					<h2>Students in the Database</h2>
					<br />
					<table width="90%" class="general">
						<tr>
							<th>student_id</th>
							<th>class_id</th>
							<th>Firstname</th>
							<th>Lastname</th>
							<th>Username</th>
							<th>Car(s) Assigned</th>
							<th width="140">Action</th>
						</tr>
					<?php if ($_smarty_tpl->tpl_vars['students']->value) {?>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['students']->value, 'row', false, 'i');
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
$__foreach_row_0_saved = $_smarty_tpl->tpl_vars['row'];
?>	
							<tr>
								<td><?php echo $_smarty_tpl->tpl_vars['row']->value['student_id'];?>
</td>
								<?php if ($_smarty_tpl->tpl_vars['row']->value['class_id'] == 0) {?>
									<td><em class="red">None</em></td>
								<?php } else { ?>
									<?php if ($_smarty_tpl->tpl_vars['row']->value['class_active']) {?>
										<td class="active" title="This class is active"><?php echo $_smarty_tpl->tpl_vars['row']->value['class_id'];?>
 - <?php echo $_smarty_tpl->tpl_vars['row']->value['class_name'];?>
</td>
									<?php } else { ?>
										<td class="inactive" title="This class is inactive"><?php echo $_smarty_tpl->tpl_vars['row']->value['class_id'];?>
 - <?php echo $_smarty_tpl->tpl_vars['row']->value['class_name'];?>
</td>
									<?php }?>
								<?php }?>
								
								<td><?php echo $_smarty_tpl->tpl_vars['row']->value['firstname'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['row']->value['lastname'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['row']->value['username'];?>
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
$__foreach_car_1_saved = $_smarty_tpl->tpl_vars['car'];
?>
										<tr>
											<td><?php echo $_smarty_tpl->tpl_vars['car']->value['car_id'];?>
</td>
											<td><img src="/img/anki_icons/<?php echo $_smarty_tpl->tpl_vars['car']->value['car_type'];?>
.webp" width="50" /></td>
											<td><?php echo $_smarty_tpl->tpl_vars['car']->value['car_mac_address'];?>
</td>
										</tr>
									<?php
$_smarty_tpl->tpl_vars['car'] = $__foreach_car_1_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
									</table>
								<?php } else { ?>
									<em class="red">None</em>
								<?php }?>
								
								</td>
								<td>
									<a href="students_edit.php?student_id=<?php echo $_smarty_tpl->tpl_vars['row']->value['student_id'];?>
" class="button_link" id="edit_student_button" title="edit student <?php echo $_smarty_tpl->tpl_vars['row']->value['student_id'];?>
"><span class="glyphicon glyphicon-edit"></span></a>
									<a href="students_delete.php?student_id=<?php echo $_smarty_tpl->tpl_vars['row']->value['student_id'];?>
" class="button_link delete_student_button" title="delete student <?php echo $_smarty_tpl->tpl_vars['row']->value['student_id'];?>
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
							<td colspan="8"><em>Currently there are no records in the students table.</em></td>
						</tr>
					<?php }?>
						
					</table>
					<?php if ($_smarty_tpl->tpl_vars['students']->value) {?>
						<br />
						<br />
                        <a href="/students_export_csv.php" class="button_link" id="export_students"><span class="glyphicon glyphicon-open"></span>&nbsp;&nbsp;Export CSV for Command Line Script</a>
                        
						<a href="/students_delete_all.php" class="button_link" id="delete_students"><span class="glyphicon glyphicon-trash"></span>&nbsp;&nbsp;Delete all students</a>
					<?php }?>
					<br />
					<br />
					<br />
					<hr>
					<h2>Add a new student</h2>
					<br />
					<strong>This will:</strong>
					<br />
						&nbsp;&nbsp;- add the student to the database<br />
						&nbsp;&nbsp;- create a restricted user account on the Linux machine for them (without sudo privileges)<br />
						&nbsp;&nbsp;- copy the original Python code files from <em>/home/pi/DET-Python-Anki-Overdrive</em> for the student to access and modify safely<br />
					<br />
					<br />
					<table width="70%" class="general" id="students_table">
						<tr>
							<th>Firstname
								<br />
								<span class="explanatory_text">Alphanumeric characters only, no special characters</span>
							</th>
							<th>Lastname
								<br />
								<span class="explanatory_text">Alphanumeric characters only, no special characters</span>
							</th>
							<th>class_id
								<br />
								<span class="explanatory_text">This links the student to other students<br> on the same Anki Overdrive track</span>
							</th>
							<th>Password
								<br />
								<span class="explanatory_text">Click <a href="" id="generatePassword">here</a> to randomly generate </span>
							</th>
						</tr>
						<tr>
							<td><input type="text" name="firstname" id="firstname" maxlength="50" required></td>
							<td><input type="text" name="lastname" id="lastname" maxlength="50" required></td>
							<td>
							
							<?php if ($_smarty_tpl->tpl_vars['classes']->value) {?>
								<select name="class_id" id="class_id">
									<option value="0">-- Please select --</option>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['classes']->value, 'class', false, 'i');
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['class']->value) {
$_smarty_tpl->tpl_vars['class']->_loop = true;
$__foreach_class_2_saved = $_smarty_tpl->tpl_vars['class'];
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['class']->value['class_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['class']->value['class_id'];?>
 - <?php echo $_smarty_tpl->tpl_vars['class']->value['name'];?>
</option>
								<?php
$_smarty_tpl->tpl_vars['class'] = $__foreach_class_2_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
								</select>
							<?php } else { ?>
								<em>No classes exist - <a href="classes.php">create one</a>?</em>
								<br />
								<br />
								Otherwise students will be assigned to a class_id of 0 ("None")
								<!-- hidden field to assign student a class id=0 -->
								<input type="hidden" name="class_id" value="0">
							<?php }?>
							</td>
							<td><input type="text" name="password" id="user_password" required></td>
						</tr>
					</table>
					<br />
					<br />
					<input type="submit" value="Save" id="student_save_button">&nbsp;&nbsp;&nbsp;
					<input type="button" value="Cancel" class="generic_button" title="/students.php">
					
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
