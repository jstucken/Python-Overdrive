

<form method="POST" action="add.php">

    <!-- About Section -->
    <section class="generic">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>MANUALLY ADD TEST DATA</h1>
                    <hr class="star-primary">
					<br />
					<br />
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 text-center">
					<span class="required">* required field</span>
					<br />
					<br />
					<table width="50%" class="general">
						<tr>
							<th>Field</th>
							<th>Value</th>
						</tr>
                        <tr>
							<td>Student ID</td>
							<td><input type="text" name="student_id" placeholder="eg 1" maxlength="20" style="width: 100px"></td>
						</tr>
						<tr>
							<td>Car ID</td>
							<td>
								<input type="text" name="car_id" placeholder="eg 1" maxlength="50" style="width: 200px" required>
							</td>
						</tr>
						<tr>
							<td>Speed <span class="required">*</span></td>
							<td><input type="text" name="speed" placeholder="eg 300" maxlength="20" style="width: 100px" required></td>
						</tr>
						<tr>
							<td>Car Type <span class="required">*</span></td>
							<td><input type="text" name="car_type" placeholder="eg Ice Charger" maxlength="50" style="width: 200px" required></td>
						</tr>
                        <tr>
							<td>Custom Field 1</td>
							<td><input type="text" name="custom_field1" placeholder="eg data of student's choice" maxlength="50" style="width: 200px" required></td>
						</tr>
                         <tr>
							<td>Custom Field 2</td>
							<td><input type="text" name="custom_field2" placeholder="eg data of student's choice" maxlength="50" style="width: 200px" required></td>
						</tr>
                         <tr>
							<td>Custom Field 3</td>
							<td><input type="text" name="custom_field3" placeholder="eg data of student's choice" maxlength="50" style="width: 200px" required></td>
						</tr>
						
					</table>
					
					<br />
					<br />
					<input type="button" value="Cancel" class="generic_button" title="/">
					&nbsp;
					&nbsp;
					<input type="submit" value="Save">
					
					
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
	
	