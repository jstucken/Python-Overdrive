
	<form method="POST" action="students_edit.php">
	
    <!-- About Section -->
    <section class="generic">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>EDIT STUDENT {$student.student_id}</h1>
                    <hr class="star-primary">
					<br />
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 text-center">
                <br />
				<table width="70%" class="general">
					<tr>
						<th style="width: 150px">student_id</th>
						<td>{$student.student_id}</td>
					</tr>
					<tr>
						<th>Class ID</th>
						<td>
						{if $classes}
							<select name="class_id" id="class_id">
								<option value="0">None</option>
							{foreach from=$classes key=i item=class}
								<option value="{$class.class_id}"{if $student.class_id==$class.class_id} selected{/if}>{$class.class_id} - {$class.name}</option>
							{/foreach}
							</select>
						{else}
							<em>No classes exist - <a href="classes.php">create one</a>?</em>
							<br />
							<br />
							Otherwise student will be assigned to class_id 0 (None)
                            <input type="hidden" name="class_id" value="0">
						{/if}
						</td>
					</tr>
					<tr>
						<th>Firstname</th>
						<td><input type="text" name="firstname" maxlength="50" required value="{$student.firstname}"></td>
					</tr>
					<tr>
						<th>Lastname</th>
						<td><input type="text" name="lastname" maxlength="50" required value="{$student.lastname}"></td>
					</tr>
					<tr>
						<th>Username
							<br />
							<span class="explanatory_text">Cannot be changed</span>
						</th>
						<td>{$student.username}</td>
					</tr>
					<tr>
						<th>Password</th>
						<td><input type="button" value="Change Password" class="coming_soon"></td>
					</tr>
					<tr>
						<th>Car(s) Assigned
						<br />
						<span class="explanatory_text">Tick the checkboxes to assign cars</span>
						</th>
						<td>
						{if $saved_cars}
							<table width="100%" class="small_table">
								<tr>
									<th>Assign?</th>
									<th>car_id</th>
									<th>Type</th>
									<th>Description</th>
									<th>MAC Address</th>
								</tr>
							{foreach from=$saved_cars key=i item=car}
								<tr>
									<td>
										<div class="checkbox-container">
											<label class="checkbox-label">
												<input type="checkbox" name="assigned_cars[]" value="{$car.car_id}" {if ($s->isCarAssignedToStudent($student_id,$car.car_id))}checked{/if}>
												<span class="checkbox-custom rectangular"></span>
											</label>
										</div>
									</td>
									<td>{$car.car_id}</td>
									<td><img src="/img/anki_icons/{$car.type}.webp" width="50" title="{$car.type_readable}" alt="{$car.type_readable}" />&nbsp;{$car.type_readable}</td>
									<td>{$car.description}</td>
									<td>{$car.mac_address}</td>
								</tr>
							{/foreach}
							</table>
						{else}
							<em class="red">None</em>
						{/if}
						</td>
					</tr>
				</table>
				
				<br />
				<input type="submit" value="Save">&nbsp;&nbsp;&nbsp;
				
				<input type="button" value="Cancel" class="generic_button" title="/students.php">
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
