<?php
	require('../header.php');
	require('sidebar.php');
?>


<div id="contents">
 	<h1 class="body_title">Members of Culture Council</h1>
<?php

	$query="SELECT  `post`, `name`, `contact_no`, `mail_id`, `batch` FROM `culture` WHERE 1";
 	$query_run=mysql_query($query);
	echo mysql_error();
	
	echo "<table>"; // start a table tag in the HTML
    echo "<tr><th>Post</th><th>Name</th><th>Contact Number</th><th>Mail ID</th><th>Batch</th></tr>";
	while($row = mysql_fetch_array($query_run))	//Creates a loop to loop through results
	{   
	//echo <tr><th>Post</th><th>Name</th><th>Contact Number</th><th>Mail ID</th><th>Batch</th></tr>;
        
	echo "<tr><td>" . $row['post'] . "</td><td>" . $row['name'] . "</td><td>" . $row['contact_no'] . "</td><td>" . $row['mail_id'] . "</td><td>" . $row['batch'] . "</td></tr>";  //$row['index'] the index here is a field name
	}

	echo "</table>";

?>
</div>

<?php
	require('../footer.php');
?>