

<form method="POST" action="classes.php">

    <!-- About Section -->
    <section class="generic">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>SETUP CLASSES</h1>
                    <hr class="star-primary">
					Use the tables below to create and manage classes.
					<br />
					<br />
					Then use the <a href="students.php">Students page</a> to assign students to your classes.
					<br />
					<br />
					Classes can be disabled to prevent certain students accessing cars if another class (group) needs to use them.
					<br />This can help reduce conflicts when you have multiple tracks/servers running within the same physical room and within Bluetooth range of eachother.
					<br />
					<br />
					<br />
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 text-center">
					<h2>Classes</h2>
					<br />
					<table width="100%" class="general small_text">
						<tr>
							<th>class_id</th>
							<th>Class Name</th>
							<th>Description</th>
							<th>Students</th>
							<th>Cars Used</th>
							<th>Last Modified</th>
							<th>Active?</th>
							<th style="width: 130px;">Action</th>
						</tr>
					{if $classes}
						{foreach from=$classes key=i item=row}	
							<tr>
								<td>{$row.class_id}</td>
								<td>{$row.name}</td>
								<td>{$row.description}</td>
								<td>
								{* Does this class have students assigned to it? *}
								{if $row.students}
									<table width="100%" class="small_table">
										<tr>
											<th>student_id</th>
											<th>Username</th>
										</tr>
									{foreach from=$row.students key=i item=student}
										<tr>
											<td>{$student.student_id}</td>
											<td>{$student.username}</td>
										</tr>
									{/foreach}
										<tr>
											<td></td>
											<td><strong>{count($row.students)} total</strong></td>
										</tr>
									</table>
									<br />
								{else}
									<em class="red">None</em>
								{/if}
								</td>
								<td>
								{* Does this class have cars assigned to it? *}
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
											<td><img src="/img/anki_icons/{$car.type}.webp" width="50" /></td>
											<td>{$car.mac_address}</td>
										</tr>
									{/foreach}
									</table>
								{else}
									<em class="red">None</em>
								{/if}
								</td>
								<td>{$row.modified}</td>
								{if ($row.active)}
									<td class="active">YES</td>
								{else}
									<td class="inactive">NO</td>
								{/if}
								<td>
									<a href="classes_edit.php?class_id={$row.class_id}" class="button_link" id="edit_car_button" title="edit class {$row.class_id}"><span class="glyphicon glyphicon-edit"></span></a>
									<a href="classes_delete.php?class_id={$row.class_id}" class="button_link delete_class_button" title="delete class {$row.class_id}"><span class="glyphicon glyphicon-trash"></span></a>
								</td>
							</tr>
						{/foreach}
					{else}
						<tr>
							<td colspan="8"><em>Currently there are no existing classes in the database. Use the form below to create a new class.</em></td>
						</tr>
					{/if}
						
					</table>
					<br />
					<br />
					<hr>
					<br />
					<h2>Create a new Class</h2>
					<br />
					<span class="required">* required field</span>
					<br />
					<br />
					<table width="50%" class="general">
						<tr>
							<th>Class Name <span class="required">*</span>
								<br />
								<span class="explanatory_text">e.g. Year 8A</span>
							</th>
							<th>Description
								<br />
								<span class="explanatory_text">e.g. Mr Smith's 2021 Year 8A class</span>
							</th>
						</tr>
						<tr>
							<td><input type="text" name="class_name" style="width: 200px" maxlength="50" required></td>
							<td><input type="text" name="description" style="width: 300px" maxlength="100"></td>
						</tr>
					</table>
					<br />
					<br />
					<input type="submit" value="Save">&nbsp;&nbsp;&nbsp;
					<input type="button" value="Cancel" class="generic_button" title="/classes.php">
					
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
	
	