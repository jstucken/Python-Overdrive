<?php
/* Smarty version 3.1.30-dev/47, created on 2021-06-27 09:32:30
  from "/var/www/html/templates/wifi.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/47',
  'unifunc' => 'content_60d7b90e15dc05_46943471',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8abaace8089ca2835c927f88792e659d4b478b24' => 
    array (
      0 => '/var/www/html/templates/wifi.tpl',
      1 => 1624750006,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60d7b90e15dc05_46943471 (Smarty_Internal_Template $_smarty_tpl) {
?>


<form method="POST" action="wifi.php" id="wifi_form">

    <!-- About Section -->
    <section class="generic">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>SETUP DET WIFI</h1>
                    <hr class="star-primary">
					Teachers can use this page to connect to the DET school wifi network.
                    <br />
                    <br />
                    This feature has been tested on DET 'Internet at Edge' networks.
					<br />
					<br />
                    Only use this page for DET wifi connectivity.
                    <br>Ethernet connection to the DET school network should work<br />
                    'plug and play' without any additional steps - just plug in an ethernet cable and you <br>
                    should then be connected to the school's local area network.
                    <br />
                    <br />
					For other wifi networks (e.g. a non-Edge school or a home network etc), use the<br>
                    desktop wifi icon to connect instead, as per the image below:
					<br />
					<br />
                    <img src="img/wifi_showing_connected.png" title="Wifi icon showing connected" width="292" height="84" />
					<br />
					<br />
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 text-center">
					<br />
					<hr>
					<h2>Enter your DET network credentials</h2>
					<br />
					<strong>Tips:</strong>
					<br />
						&nbsp;&nbsp;Use your shortened DET network username <br />
						&nbsp;&nbsp;e.g. if your email address was john_smith@det.nsw.edu.au
                        <br>your shortened network name would likely be <em><strong>jsmith</strong></em>
                        <br />
                        <br />
                        Check with your school's I.T. coordinator if you are not sure.
                        <br />
                        <br />
                        Your password will <em><strong>not</strong></em> be stored in the local database
                        <br>
                        but will be encrypted (hashed) and saved in:
                        <br>
                        <em>/etc/wpa_supplicant/wpa_supplicant.conf</em>, accessible to the root user only.
					<br />
					<br />
					<table width="50%" class="general" id="wifi_credentials_table">
						<tr>
							<th style="width: 40%">DET network username:
								<br />
								<span class="explanatory_text">e.g john_smith NOT john_smith@det.nsw.edu.au</span>
							</th>
                            <td><input type="text" name="username" id="username" maxlength="50" required style="width: 220px"></td>
                        </tr>
                        <tr>
							<th>Password:
								<br />
								<span class="explanatory_text">Your normal DET password</span>
							</th>
                            <td><input type="password" name="password" id="password" maxlength="30" required style="width: 220px"></td>
                        </tr>
                        <tr>
							<th>Confirm password:</th>
                            <td><input type="password" name="confirm_password" id="confirm_password" maxlength="30" required style="width: 220px"></td>
						</tr>
					</table>
					<br />
					<br />
					<input type="submit" value="Save" id="wifi_save_button">&nbsp;&nbsp;&nbsp;
					<input type="button" value="Cancel" class="generic_button" title="/wifi.php">
					
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
