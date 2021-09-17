<?php
require_once ('../includes/site_config.php');
require_once ('../includes/smarty_config.php');

// get players
$select_sql = "SELECT username,COUNT(*) as counter FROM cars_data GROUP BY username";

$select_results = $db->getRows($select_sql);
//dbug($select_results,'select_results');

// sample pie chart
$data = '
{
  "cols": [
        {"id":"","label":"Topping","pattern":"","type":"string"},
        {"id":"","label":"Slices","pattern":"","type":"number"}
      ],
  "rows": [';

$num_rows = count($select_results);
//dbug($num_rows,'$num_rows');

 foreach ($select_results as $key => $row) {
	 
	 //debug($key,'$key');
	 $username = $row['username'];
	 $counter = $row['counter'];
	 
	 $data .= '
        {"c":[{"v":"'.$username.'","f":null},{"v":'.$counter.',"f":null}]},';
}
	$data .= '{"c":[{"v":"Unknown","f":null},{"v":1,"f":null}]}
      ]
}';

echo $data;

?>