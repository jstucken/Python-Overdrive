

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
                    {if $scanned_cars_new}
						{foreach from=$scanned_cars_new key=i item=car_mac}	
						<tr>
							<td>{$car_mac} <input type="hidden" name="car_mac[{$i}]" value="{$car_mac}"></td>
							<td>
							<!-- List of Anki cars can be found at this URL: https://anki-overdrive.fandom.com/wiki/Vehicles -->
								<select name="car_type[{$i}]" class="car_type" tabindex="1">
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
							<td><input type="text" name="description[{$i}]" style="width: 170px; font-size: 10px" maxlength="50" tabindex="2" id="car_description"></td>
							<td><a href="cars_add.php" class="button_link car_add_button" title="{$i}"><span class="glyphicon glyphicon-floppy-disk" tabindex="3"></span>&nbsp;Save</a>
							
							</td>
						</tr>
						{/foreach}
					{else}
						<tr>
							<td colspan="4"><em>No new Anki Bluetooth cars found in the scan. Click the 'Rescan' button below to try again.</em></td>
						</tr>
					{/if}
					</table>
					</form>
                    <br />
					<input type="button" value="Rescan" class="generic_button" title="/cars.php?rand={php}echo rand();{/php}">
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
					{if $saved_cars}
						{foreach from=$saved_cars key=i item=row}	
						<tr>
							<td>{$row.car_id}</td>
							<td>{$row.mac_address}</td>
							<td><img src="/img/anki_icons/{$row.type}.webp" width="50" /> &nbsp;{$row.type_readable}</td>
							<td>{$row.description}</td>
						{if (in_array($row.mac_address,$scanned_cars_all))}
							<td style="background-color: green; color: white; text-align: center">ON</td>
						{else}
							<td style="background-color: red; color: white; text-align: center">OFF</td>
						{/if}
							</td>
							<td>
							<a href="cars_edit.php?car_id={$row.car_id}" class="button_link" id="edit_car_button" title="edit car {$row.car_id}"><span class="glyphicon glyphicon-edit"></span></a>
							<a href="cars_delete.php?car_id={$row.car_id}" class="button_link delete_car_button" title="delete car {$row.car_id}"><span class="glyphicon glyphicon-trash"></span></a>
							</td>
						</tr>
						{/foreach}
					{else}
						<tr>
							<td colspan="7"><em>Currently there are no saved cars in the Database. Add some by using the scan feature above.</em></td>
						</tr>
					{/if}
						
					</table>
					
					<br />
					<input type="button" value="Refresh" class="generic_button" title="/cars.php?rand={php}echo rand();{/php}">
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
