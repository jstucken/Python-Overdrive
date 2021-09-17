


    <!-- About Section -->
    <section class="generic">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>VIEW DATA</h1>
                    <hr class="star-primary">
					<br />
					<br />
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 text-center">
								
					<a href="/add.php" class="button_link"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Manually add test data</a>&nbsp;&nbsp;<a href="/view_export_csv.php" class="button_link"><span class="glyphicon glyphicon-floppy-save"></span>&nbsp;&nbsp;Export CSV</a>
					
					<br />
					<br />
					<strong>Showing the most recent 100 rows below, in descending order:</strong>
					<br />
					<br />
					<table width="90%" class="general">
					
						<tr>
							<th>id</th>
							<th>Date Time (inc. milliseconds)</th>
							<th>student_id</th>
							<th>car_id</th>
							<th>mac_address</th>
							<th>username</th>
							<th>speed</th>
							<th>location</th>
							<th>car_type</th>
							<th>custom_field1</th>
							<th>custom_field2</th>
							<th>custom_field3</th>
						</tr>
					{foreach from=$results key=i item=row}	
						<tr>
							<td>{$row.id}</td>
							<td>{$row.date_time_micro}</td>
							<td>{$row.student_id}</td>
							<td>{$row.car_id}</td>
							<td>{$row.mac_address}</td>
							<td>{$row.username}</td>
							<td>{$row.speed}</td>
							<td>{$row.location}</td>
							<td>{$row.car_type}</td>
							<td>{$row.custom_field1}</td>
							<td>{$row.custom_field2}</td>
							<td>{$row.custom_field3}</td>
						</tr>
					{/foreach}
						
					</table>
					
					
				</div>
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <!--<a href="#" class="btn btn-lg btn-outline">
                        <i class="fa fa-download"></i> Download Theme
                    </a>-->
                </div>
            </div>
        </div>
    </section>
	
	
	