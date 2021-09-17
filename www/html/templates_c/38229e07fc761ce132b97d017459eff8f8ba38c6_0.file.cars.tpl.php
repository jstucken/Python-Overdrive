<?php
/* Smarty version 3.1.30-dev/47, created on 2021-06-27 14:55:51
  from "/var/www/html/templates/cars.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/47',
  'unifunc' => 'content_60d804d7d25715_11136372',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '38229e07fc761ce132b97d017459eff8f8ba38c6' => 
    array (
      0 => '/var/www/html/templates/cars.tpl',
      1 => 1624100714,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60d804d7d25715_11136372 (Smarty_Internal_Template $_smarty_tpl) {
?>


    <!-- About Section -->
    <section class="generic">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>SETUP CARS</h1>
                    <hr class="star-primary">
					<br />
					Use this page to scan for nearby Anki Overdrive cars, then save them to the database for use.
					<br />
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 text-center">
                <br />
                <br />
                <h2>New Scanned Cars In Range</h2>
                    <br />
					To appear in this list, cars must be powered on, within range and <em><strong>not</strong></em> already saved in the database.
					<br />
					i.e. only newly discovered cars will appear in this list.
					<br />
					We recommend turning on one car at a time to help identify them correctly.
                    <br />
                    <br />
					<form method="POST" action="cars_add.php" id="car_add_form">
					
					<input type="hidden" name="key" id="key">
					
					<span class="required">* required field</span>
					<br />
					<br />
					
					<table width="70%" class="general">
						<tr>
							<th>Car MAC Address</th>
							<th>Car Type <span class="required">*</span></th>
							<th>Description
							<br />
							<span class="explanatory_text">e.g. Nuke with custom 3D printed shell</span>
							</th>
							<th>Action</th>
						</tr>
                    <?php if ($_smarty_tpl->tpl_vars['scanned_cars_new']->value) {?>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['scanned_cars_new']->value, 'car_mac', false, 'i');
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['car_mac']->value) {
$_smarty_tpl->tpl_vars['car_mac']->_loop = true;
$__foreach_car_mac_0_saved = $_smarty_tpl->tpl_vars['car_mac'];
?>	
						<tr>
							<td><?php echo $_smarty_tpl->tpl_vars['car_mac']->value;?>
 <input type="hidden" name="car_mac[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
]" value="<?php echo $_smarty_tpl->tpl_vars['car_mac']->value;?>
"></td>
							<td>
							<!-- List of Anki cars can be found at this URL: https://anki-overdrive.fandom.com/wiki/Vehicles -->
								<select name="car_type[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
]" class="car_type" tabindex="1">
									<option value="">-- Please select --</option>
									<option value="big_bang">Big Bang</option>
									<option value="custom">Custom</option>
									<option value="ice_charger">Ice Charger</option>
									<option value="freewheel">Freewheel (Truck)</option>
									<option value="guardian">Guardian</option>
									<option value="groundshock">GroundShock</option>
									<option value="mxt">International MXT</option>
									<option value="nuke">Nuke</option>
									<option value="nuke_phantom">Nuke Phantom</option>
									<option value="other">Other</option>
									<option value="skull">Skull</option>
									<option value="thermo">Thermo</option>
									<option value="x52">X52 (Truck)</option>
									<option value="x52_ice">X52 Ice (Truck)</option>
								</select>
							</td>
							<td><input type="text" name="description[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
]" style="width: 170px; font-size: 10px" maxlength="50" tabindex="2" id="car_description"></td>
							<td><a href="cars_add.php" class="button_link car_add_button" title="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"><span class="glyphicon glyphicon-floppy-disk" tabindex="3"></span>&nbsp;Save</a>
							
							</td>
						</tr>
						<?php
$_smarty_tpl->tpl_vars['car_mac'] = $__foreach_car_mac_0_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
					<?php } else { ?>
						<tr>
							<td colspan="4"><em>No new Anki Bluetooth cars found in the scan. Click the 'Rescan' button below to try again.</em></td>
						</tr>
					<?php }?>
					</table>
					</form>
                    <br />
					<input type="button" value="Rescan" class="generic_button" title="/cars.php?rand=<?php echo rand();?>">
					<br />
					<br />
                    <hr>
					<br />
                    <h2>Cars Saved in Database</h2>
                    <br />
                    These cars can be <a href="students.php">assigned to students</a> to control via Python scripts, running on this server.
                    <br />
                    <br />
                    
					<table width="80%" class="general">
						<tr>
							<th>Car ID</th>
							<th>Car MAC Address</th>
							<th>Car Type</th>
							<th>Description</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					<?php if ($_smarty_tpl->tpl_vars['saved_cars']->value) {?>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['saved_cars']->value, 'row', false, 'i');
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
$__foreach_row_1_saved = $_smarty_tpl->tpl_vars['row'];
?>	
						<tr>
							<td><?php echo $_smarty_tpl->tpl_vars['row']->value['car_id'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['row']->value['mac_address'];?>
</td>
							<td><img src="/img/anki_icons/<?php echo $_smarty_tpl->tpl_vars['row']->value['type'];?>
.webp" width="50" /> &nbsp;<?php echo $_smarty_tpl->tpl_vars['row']->value['type_readable'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['row']->value['description'];?>
</td>
						<?php if ((in_array($_smarty_tpl->tpl_vars['row']->value['mac_address'],$_smarty_tpl->tpl_vars['scanned_cars_all']->value))) {?>
							<td style="background-color: green; color: white; text-align: center">ON</td>
						<?php } else { ?>
							<td style="background-color: red; color: white; text-align: center">OFF</td>
						<?php }?>
							</td>
							<td>
							<a href="cars_edit.php?car_id=<?php echo $_smarty_tpl->tpl_vars['row']->value['car_id'];?>
" class="button_link" id="edit_car_button" title="edit car <?php echo $_smarty_tpl->tpl_vars['row']->value['car_id'];?>
"><span class="glyphicon glyphicon-edit"></span></a>
							<a href="cars_delete.php?car_id=<?php echo $_smarty_tpl->tpl_vars['row']->value['car_id'];?>
" class="button_link delete_car_button" title="delete car <?php echo $_smarty_tpl->tpl_vars['row']->value['car_id'];?>
"><span class="glyphicon glyphicon-trash"></span></a>
							</td>
						</tr>
						<?php
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_1_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
					<?php } else { ?>
						<tr>
							<td colspan="7"><em>Currently there are no saved cars in the Database. Add some by using the scan feature above.</em></td>
						</tr>
					<?php }?>
						
					</table>
					
					<br />
					<input type="button" value="Refresh" class="generic_button" title="/cars.php?rand=<?php echo rand();?>">
					<br />
					<br />
					
				</div>
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <!--<a href="#" class="btn btn-lg btn-outline">
                        <i class="fa fa-download"></i> Download Theme
                    </a>-->
                </div>
            </div>
        </div>
    </section>
<?php }
}
