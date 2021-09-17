

<form method="POST" action="sql.php#run_sql" id="sql_form">
	
    <!-- About Section -->
    <section class="generic">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>SQL EDITOR</h1>
                    <hr class="star-primary">
					<br />
					<br />
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 text-center large_text">
					<br />
					<strong>Run some custom SQL of your choosing on the local database.</strong>
					<br />
					<br />
					The following SQL commands are not permitted:
					<br />
					{foreach from=$banned_words key=i item=word}
						{$word}<br />
					{/foreach}
						
					<br />
					<br />
					<strong>Examples:</strong>
					<br />
					<br />
					<table width="70%" class="general">
						<tr>
							<th>Example 1 - Get everything from the cars_data table</th>
							<th>Example 2 - See all fields in the cars_data table</th>
							<th>Example 3 - Show all tables in the database</th>
						</tr>
						<tr>
							<td>SELECT * FROM cars_data</td>
							<td>SHOW COLUMNS FROM cars_data</td>
							<td>SHOW TABLES</td>
						</tr>
					</table>
                    <a name="run_sql"></a>
					<br />
					<br />
					<strong>YOUR SQL:</strong>
					<br />
					<br />
					<table width="70%" class="general">
						<tr>
							<th>YOUR SQL:</th>
						</tr>
						<tr>
							<td><textarea name="user_sql" id="user_sql" class="user_sql" placeholder="Enter your SQL here..." style="min-height: 100px">{$user_sql}</textarea></td>
						</tr>
						
					</table>
					<br />
					<a href="#run_sql" class="button_link form_submit"><span class="glyphicon glyphicon-play"></span>&nbsp;&nbsp;Run SQL</a> 
					
					<br />
					<br />
					{if $mysql_error}
                        <div style="color: red; font-weight: bold; font-size: 26px">MYSQL ERROR: {$mysql_error}</div>
                        <br />
                    {/if}
                    <hr>
					<h2>{$results_count} RESULTS</h2>
					<br />
                    {if $results}
                        <div>
                            <a href="/sql_export_csv.php" class="button_link"><span class="glyphicon glyphicon-floppy-save"></span>&nbsp;&nbsp;Export CSV</a>
                        </div>
                    {/if}
					<!-- SHOW DB fields -->
                    <br />
					<table width="90%" class="general">
						<tr>
							
						{foreach from=$user_fields key=c item=field}
							<th>{$field}</th>
						{/foreach}
						</tr>
					
						{if $results}
							
							{foreach from=$results key=i item=result}	
								<tr>
								{foreach from=$user_fields key=col_id item=field}
									<td>{$result.$field}</td>
								{/foreach}
								</tr>
							{/foreach}
						{else}
							Your query returned no results
						{/if}
						
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
	
</form>
	
	
	