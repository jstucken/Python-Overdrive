
	<form method="POST" action="cars_edit.php">
	
    <!-- About Section -->
    <section class="generic">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>EDIT CAR {$car_data.car_id}</h1>
                    <hr class="star-primary">
					<br />
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 text-center">
                <br />
				<table width="70%" class="general">
					<tr>
						<th>Car ID</th>
						<th>Car MAC Address</th>
						<th>Car Type</th>
						<th>Description</th>
					</tr>
					<tr>
						<td>{$car_data.car_id}</td>
						<td>{$car_data.mac_address}</td>
						<td><img src="/img/anki_icons/{$car_data.type}.webp" width="50" />&nbsp;&nbsp;
						<select name="car_type" class="car_type">
							<option value="big_bang" {if $car_data.type eq 'big_bang'}selected{/if}>Big Bang</option>
							<option value="custom" {if $car_data.type eq 'custom'}selected{/if}>Custom</option>
							<option value="ice_charger" {if $car_data.type eq 'ice_charger'}selected{/if}>Ice Charger</option>
							<option value="freewheel" {if $car_data.type eq 'freewheel'}selected{/if}>Freewheel (Truck)</option>
							<option value="guardian" {if $car_data.type eq 'guardian'}selected{/if}>Guardian</option>
							<option value="groundshock" {if $car_data.type eq 'groundshock'}selected{/if}>GroundShock</option>
							<option value="mxt" {if $car_data.type eq 'mxt'}selected{/if}>International MXT</option>
							<option value="nuke" {if $car_data.type eq 'nuke'}selected{/if}>Nuke</option>
							<option value="nuke_phantom" {if $car_data.type eq 'nuke_phantom'}selected{/if}>Nuke Phantom</option>
							<option value="other" {if $car_data.type eq 'other'}selected{/if}>Other</option>
							<option value="skull" {if $car_data.type eq 'skull'}selected{/if}>Skull</option>
							<option value="thermo" {if $car_data.type eq 'thermo'}selected{/if}>Thermo</option>
							<option value="x52" {if $car_data.type eq 'x52'}selected{/if}>X52 (Truck)</option>
							<option value="x52_ice" {if $car_data.type eq 'x52_ice'}selected{/if}>X52 Ice (Truck)</option>
						</select>
						</td>
						<td><input type="text" name="description" style="width: 170px; font-size: 10px" maxlength="50" value="{$car_data.description}"></td>
					</tr>
				</table>
				
				<br />
				<input type="submit" value="Save" class="disable_when_clicked">&nbsp;&nbsp;&nbsp;
				
				<input type="button" value="Cancel" class="generic_button" title="/cars.php">
				<br />
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
	
	</form>
