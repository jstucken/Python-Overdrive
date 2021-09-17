
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
                            {if (strlen($local_ip_address) > 1)}
								<span class="active">&nbsp;{$local_ip_address}&nbsp;</span>
                            {else}
								<span class="inactive">&nbsp;Please connect to a local area network first. See <a href="wifi.php">wifi page</a>&nbsp;</span>
                            {/if}
                            </td>
                        </tr>
                        <tr>
                            <th>URL to this GUI:
                                <br />
								<span class="explanatory_text">Students and teachers can use this to access this GUI over the LAN</span>
                            </th>
                            <td><a href="{$local_web_app_url}">{$local_web_app_url}</a></td>
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
                                
                                ssh john_smith@{$local_ip_address}
                                
                                </span>
                            </th>
                            <td>ssh <strong>username</strong>@{$local_ip_address}</td>
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
                            <td>{$version}</td>
                        </tr>
                        <tr>
                            <th style="width: 350px">Raspbian version:</th>
                            <td>{$rasp_version}</td>
                        </tr>
                        <tr>
                            <th>Date:</th>
                            <td>{$date}</td>
                        </tr>
                        <tr>
                            <th>Uptime:</th>
                            <td>{$uptime}</td>
                        </tr>
                        <tr>
                            <th>Users connected:</th>
                            <td>{$users_connected}</td>
                        </tr>
                        <tr>
                            <th>CPU Usage:</th>
                            <td>{$cpu_usage}%</td>
                        </tr>
                        <tr>
                            <th>Memory Usage:</th>
                            <td>{$memory_usage}</td>
                        </tr>
                        <tr>
                            <th>Disk Usage:</th>
                            <td>{$disk_usage}</td>
                        </tr>
                    </table>
                    <br />
                {* teacher only stuff *}
                {if $smarty.session.user}
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
                {/if}   
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
	
	
	
	