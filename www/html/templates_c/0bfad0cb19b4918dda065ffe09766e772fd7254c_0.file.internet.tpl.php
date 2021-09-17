<?php
/* Smarty version 3.1.30-dev/47, created on 2021-06-27 16:28:07
  from "/var/www/html/templates/internet.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/47',
  'unifunc' => 'content_60d81a77448bd4_22137891',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0bfad0cb19b4918dda065ffe09766e772fd7254c' => 
    array (
      0 => '/var/www/html/templates/internet.tpl',
      1 => 1624775283,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60d81a77448bd4_22137891 (Smarty_Internal_Template $_smarty_tpl) {
?>


<form method="POST" action="wifi.php" id="wifi_form">

    <!-- About Section -->
    <section class="generic">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>SETUP Internet @ Edge</h1>
                    <hr class="star-primary">
					To obtain internet access, teachers can connect the server to the DET 'Internet @ Edge'.
                    <br />
                    <br />
                    Before doing so, ensure that you have a working wifi/ethernet connection (see <a href="wifi.php">wifi page</a>).
					<br />
					<br />
					<?php if ((strlen($_smarty_tpl->tpl_vars['local_ip_address']->value) > 1)) {?>
						<span class="active">&nbsp;Local area network connection detected (<?php echo $_smarty_tpl->tpl_vars['local_ip_address']->value;?>
)&nbsp;</span>
					<?php } else { ?>
						<span class="inactive">&nbsp;Please connect to the DET network first. See <a href="wifi.php">this page</a>&nbsp;</span>
					<?php }?>
					<br />
					<br />
					<strong>Tips:</strong>
					<br />
						&nbsp;&nbsp;Use your full DET email address on the subsequent page <br />
						&nbsp;&nbsp;<em>e.g. john_smith@det.nsw.edu.au</em>
                        <br />
						Use your normal DET password on the subsequent page.
						<br />
                        <br />
						If you get stuck, please read the <a href="web_files/Secured_Internet_Edge_-_Quick_Reference_Guide.pdf">Internet @ Edge documentation</a>
						<br />
						<br />
						<br />
					<input type="button" value="Cancel" class="generic_button" title="internet.php">&nbsp;&nbsp;
					<input type="button" value="Proceed" id="internet_proceed_button" class="generic_button" title="http://detnsw.net">
					
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
