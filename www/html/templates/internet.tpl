

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
					{if (strlen($local_ip_address) > 1)}
						<span class="active">&nbsp;Local area network connection detected ({$local_ip_address})&nbsp;</span>
					{else}
						<span class="inactive">&nbsp;Please connect to the DET network first. See <a href="wifi.php">this page</a>&nbsp;</span>
					{/if}
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
	
	