<?php
/* Smarty version 3.1.30-dev/47, created on 2021-09-17 12:30:55
  from "/var/www/html/templates/index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/47',
  'unifunc' => 'content_6143fddfde37b4_47973959',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a8339e4591a4132edf23ef9a583dda3d69912170' => 
    array (
      0 => '/var/www/html/templates/index.tpl',
      1 => 1631845854,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6143fddfde37b4_47973959 (Smarty_Internal_Template $_smarty_tpl) {
?>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <!--<h2>About</h2>-->
                    <!--<hr class="star-primary">-->
					<br />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>This web application was created to help teachers and students code Anki Overdrive cars using Python text based coding.
					<br />
					<br />
                    <h3>Student Access</h3>
                    <br />
                    <table width="60%" class="general medium_table">
                        <tr>
                            <th style="width: 350px">IP Address of this server:
                                <br />
								<span class="explanatory_text">Local IP address obtained via this machine's wifi/ethernet card (ifconfig command)</span>
                            </th>
                            <td>
                            <?php if ((strlen($_smarty_tpl->tpl_vars['local_ip_address']->value) > 1)) {?>
								<span class="active">&nbsp;<?php echo $_smarty_tpl->tpl_vars['local_ip_address']->value;?>
&nbsp;</span>
                            <?php } else { ?>
								<span class="inactive">&nbsp;Please connect to a local area network first. See <a href="wifi.php">wifi page</a>&nbsp;</span>
                            <?php }?>
                            </td>
                        </tr>
                        <tr>
                            <th>URL to this GUI:
                                <br />
								<span class="explanatory_text">Students and teachers can use this to access this GUI over the LAN</span>
                            </th>
                            <td><a href="<?php echo $_smarty_tpl->tpl_vars['local_web_app_url']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['local_web_app_url']->value;?>
</a></td>
                        </tr>
                        <tr>
                            <th>SSH command:
                                <br />
								<span class="explanatory_text">Type this command into a terminal window to connect to this server.
                                <br />
                                <br />
                                Replace username with a valid student username from the <a href="students.php">students page</a>
                                <br />
                                <br />
                                e.g.
                                
                                ssh john_smith@<?php echo $_smarty_tpl->tpl_vars['local_ip_address']->value;?>

                                
                                </span>
                            </th>
                            <td>ssh <strong>username</strong>@<?php echo $_smarty_tpl->tpl_vars['local_ip_address']->value;?>
</td>
                        </tr>
                        <tr>
                            <th>Student Python Scripts Directory:
                                <br />
								<span class="explanatory_text">Replace username with a valid student username from the <a href="students.php">students page</span>
                            </th>
                            <td>/home/<strong>username</strong>/</td>
                        </tr>
                    </table>
                    <br />
                    <h3>Server Info</h3>
                    <br />
                    <table width="60%" class="general medium_table">
                        <tr>
                            <th style="width: 350px">DET-Python-Anki-Overdrive version:</th>
                            <td><?php echo $_smarty_tpl->tpl_vars['version']->value;?>
</td>
                        </tr>
                        <tr>
                            <th style="width: 350px">Raspbian version:</th>
                            <td><?php echo $_smarty_tpl->tpl_vars['rasp_version']->value;?>
</td>
                        </tr>
                        <tr>
                            <th>Date:</th>
                            <td><?php echo $_smarty_tpl->tpl_vars['date']->value;?>
</td>
                        </tr>
                        <tr>
                            <th>Uptime:</th>
                            <td><?php echo $_smarty_tpl->tpl_vars['uptime']->value;?>
</td>
                        </tr>
                        <tr>
                            <th>Users connected:</th>
                            <td><?php echo $_smarty_tpl->tpl_vars['users_connected']->value;?>
</td>
                        </tr>
                        <tr>
                            <th>CPU Usage:</th>
                            <td><?php echo $_smarty_tpl->tpl_vars['cpu_usage']->value;?>
%</td>
                        </tr>
                        <tr>
                            <th>Memory Usage:</th>
                            <td><?php echo $_smarty_tpl->tpl_vars['memory_usage']->value;?>
</td>
                        </tr>
                        <tr>
                            <th>Disk Usage:</th>
                            <td><?php echo $_smarty_tpl->tpl_vars['disk_usage']->value;?>
</td>
                        </tr>
                    </table>
                    <br />
                
                <?php if ($_SESSION['user']) {?>
                    <h3>Teacher Admin Tools</h3>
                    <br />
                    <table width="60%" class="general medium_table">
                        <tr>
                            <th style="width: 350px">Connect to DET school Wifi
                            <br />
								<span class="explanatory_text">Connect this server to the DET wifi network.</span>
                            </th>
                            <td>
                            <a href="/wifi.php" class="button_link"><span class="glyphicon glyphicon-wrench"></span>&nbsp;&nbsp;Setup DET Wifi</a>
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 350px">Connect to the Internet
                            <br />
								<span class="explanatory_text">Connect this server to the Internet via the DET's 'Secured Internet at Edge' portal.</span>
                            </th>
                            <td>
                            <a href="/internet.php" class="button_link"><span class="glyphicon glyphicon-globe"></span>&nbsp;&nbsp;Connect to the Internet</a>
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 350px">phpMyAdmin Database Admin
                            <br />
								<span class="explanatory_text">Useful in administering the local MySQL database.<br>Login with the same credentials as this GUI.</span>
                            </th>
                            <td>
                            <a href="/phpmyadmin" class="button_link" id="open_phpmyadmin"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;Open phpMyAdmin</a>
                            </td>
                        </tr>
                        <!--
						<tr>
                            <th>Download / backup all student files
                            <br />
								<span class="explanatory_text">Useful in copying student files from the server to your own computer.<br></span>
                            </th>
                            <td>
                            <a href="#" class="button_link coming_soon" id="download_student_files_button"><span class="glyphicon glyphicon-download-alt"></span>&nbsp;&nbsp;Download student files</a>
                            </td>
                        </tr>
						
                        <tr>
                            <th>Revert all student_files directories
                            <br />
								<span class="explanatory_text">This will backup all existing student directories, then copy a fresh set of files from:
                                <br>
                                <br>
                                /home/pi/DET-Python-Anki-Overdrive/student_files
                                <br>
                                <br>
                                This can be useful in quickly distributing new code samples to all students.
                                <br>
                                Use with care however, and ensure that students are not actively<br>
                                editing files at time of copying, as their work will be overwritten.<br></span>
                            </th>
                            <td>
                            <a href="#" class="button_link coming_soon" id="copy_student_files_button"><span class="glyphicon glyphicon-refresh"></span>&nbsp;&nbsp;Revert student files</a>
                            </td>
                        </tr>
						-->
                    </table>
                <?php }?>   
					<!--
					<strong>Authors:</strong>
					<br />Peter Davis
					<br />Andrew O'Brien
					<br />Jonathan Stucken
					-->
					<br />
					<!--<strong>Github link:</strong> <a href="https://github.com/jstucken/DET-Python-Anki-Overdrive">https://github.com/jstucken/DET-Python-Anki-Overdrive</a>-->
					<br />
					<br />
					<!--<span style="font-size: 18px">This page is being served by apache2 web server running on Raspbian Pi OS</span>-->
					<br />
					</p>
					<br />
					<p>
					<!--<h4>Some links which may interest you:</h4>-->
					</p>
				
					
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
