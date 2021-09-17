

<form method="POST" action="students.php" id="add_student_form">

    <!-- About Section -->
    <section class="generic">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>SETUP STUDENTS</h1>
                    <hr class="star-primary">
					Teachers can use this page to add/remove students and assign Anki cars to them.
					<br />
					<br />
					Students can be <a href="classes.php">placed into classes</a> to assist with multiple track setups.
					<br />
					<br />
					<br />
					<br />
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 text-center">
					<h2>Students in the Database</h2>
					<br />
					<table width="90%" class="general">
						<tr>
							<th>student_id</th>
							<th>class_id</th>
							<th>Firstname</th>
							<th>Lastname</th>
							<th>Username</th>
							<th>Car(s) Assigned</th>
							<th width="140">Action</th>
						</tr>
					{if $students}
						{foreach from=$students key=i item=row}	
							<tr>
								<td>{$row.student_id}</td>
								{if $row.class_id == 0}
									<td><em class="red">None</em></td>
								{else}
									{if $row.class_active}
										<td class="active" title="This class is active">{$row.class_id} - {$row.class_name}</td>
									{else}
										<td class="inactive" title="This class is inactive">{$row.class_id} - {$row.class_name}</td>
									{/if}
								{/if}
								
								<td>{$row.firstname}</td>
								<td>{$row.lastname}</td>
								<td>{$row.username}</td>
								<td>
								{* Does this student have cars assigned to them? *}
								{if $row.cars}
									<table width="100%" class="small_table">
										<tr>
											<th>car_id</th>
											<th>Type</th>
											<th>MAC Address</th>
										</tr>
									{foreach from=$row.cars key=i item=car}
										<tr>
											<td>{$car.car_id}</td>
											<td><img src="/img/anki_icons/{$car.car_type}.webp" width="50" /></td>
											<td>{$car.car_mac_address}</td>
										</tr>
									{/foreach}
									</table>
								{else}
									<em class="red">None</em>
								{/if}
								
								</td>
								<td>
									<a href="students_edit.php?student_id={$row.student_id}" class="button_link" id="edit_student_button" title="edit student {$row.student_id}"><span class="glyphicon glyphicon-edit"></span></a>
									<a href="students_delete.php?student_id={$row.student_id}" class="button_link delete_student_button" title="delete student {$row.student_id}"><span class="glyphicon glyphicon-trash"></span></a>
								</td>
							</tr>
						{/foreach}
					{else}
						<tr>
							<td colspan="8"><em>Currently there are no records in the students table.</em></td>
						</tr>
					{/if}
						
					</table>
					{if $students}
						<br />
						<br />
                        <a href="/students_export_csv.php" class="button_link" id="export_students"><span class="glyphicon glyphicon-open"></span>&nbsp;&nbsp;Export CSV for Command Line Script</a>
                        
						<a href="/students_delete_all.php" class="button_link" id="delete_students"><span class="glyphicon glyphicon-trash"></span>&nbsp;&nbsp;Delete all students</a>
					{/if}
					<br />
					<br />
					<br />
					<hr>
					<h2>Add a new student</h2>
					<br />
					<strong>This will:</strong>
					<br />
						&nbsp;&nbsp;- add the student to the database<br />
						&nbsp;&nbsp;- create a restricted user account on the Linux machine for them (without sudo privileges)<br />
						&nbsp;&nbsp;- copy the original Python code files from <em>/home/pi/DET-Python-Anki-Overdrive</em> for the student to access and modify safely<br />
					<br />
					<br />
					<table width="70%" class="general" id="students_table">
						<tr>
							<th>Firstname
								<br />
								<span class="explanatory_text">Alphanumeric characters only, no special characters</span>
							</th>
							<th>Lastname
								<br />
								<span class="explanatory_text">Alphanumeric characters only, no special characters</span>
							</th>
							<th>class_id
								<br />
								<span class="explanatory_text">This links the student to other students<br> on the same Anki Overdrive track</span>
							</th>
							<th>Password
								<br />
								<span class="explanatory_text">Click <a href="" id="generatePassword">here</a> to randomly generate </span>
							</th>
						</tr>
						<tr>
							<td><input type="text" name="firstname" id="firstname" maxlength="50" required></td>
							<td><input type="text" name="lastname" id="lastname" maxlength="50" required></td>
							<td>
							
							{if $classes}
								<select name="class_id" id="class_id">
									<option value="0">-- Please select --</option>
								{foreach from=$classes key=i item=class}
									<option value="{$class.class_id}">{$class.class_id} - {$class.name}</option>
								{/foreach}
								</select>
							{else}
								<em>No classes exist - <a href="classes.php">create one</a>?</em>
								<br />
								<br />
								Otherwise students will be assigned to a class_id of 0 ("None")
								<!-- hidden field to assign student a class id=0 -->
								<input type="hidden" name="class_id" value="0">
							{/if}
							</td>
							<td><input type="text" name="password" id="user_password" required></td>
						</tr>
					</table>
					<br />
					<br />
					<input type="submit" value="Save" id="student_save_button">&nbsp;&nbsp;&nbsp;
					<input type="button" value="Cancel" class="generic_button" title="/students.php">
					
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
	
	