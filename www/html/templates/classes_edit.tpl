
	<form method="POST" action="classes_edit.php">
	
    <!-- About Section -->
    <section class="generic">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>EDIT CLASS {$data.class_id}</h1>
                    <hr class="star-primary">
					<br />
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 text-center">
                <br />
				<table width="50%" class="general">
					<tr>
						<th>Class ID</th>
						<th>Class Name</th>
						<th>Description</th>
						<th>Active?</th>
					</tr>
					<tr>
						<td>{$data.class_id}</td>
						<td><input type="text" name="class_name" style="width: 200px; font-size: 10px" maxlength="50" value="{$data.name}" required></td>
						<td><input type="text" name="description" style="width: 250px; font-size: 10px" maxlength="100" value="{$data.description}"></td>
						<td>
							<div class="checkbox-container">
								<label class="checkbox-label">
									<input type="checkbox" name="active" value="1" {if ($data.active)}checked{/if}>
									<span class="checkbox-custom rectangular"></span>
								</label>
							</div>
						</td>
					</tr>
				</table>
				
				<br />
				<input type="submit" value="Save" class="disable_when_clicked">&nbsp;&nbsp;&nbsp;
				
				<input type="button" value="Cancel" class="generic_button" title="/classes.php">
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
