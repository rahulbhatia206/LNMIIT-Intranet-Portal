<?php
	require('../header.php');
	require('sidebar.php');
?>


<div id="contents">
 	<h1 class="body_title">Members of Science & Tech Council</h1>
<?php

	$query="SELECT   `post`,`name`,`rollno`,`emailid`,`contact` FROM `science&tech` WHERE 1";
 	$query_run=mysql_query($query);
	echo mysql_error();
	
	echo "<table>"; // start a table tag in the HTML
	echo "<tr><th>Post</th><th>Name</th><th>Roll number</th><th>EMail ID</th><th>Contact Number</th></tr>";
	while($row = mysql_fetch_array($query_run))	//Creates a loop to loop through results
	{   
	//echo <tr><th>Post</th><th>Name</th><th>Contact Number</th><th>Mail ID</th><th>Batch</th></tr>;
	echo "<tr><td>" . $row['post'] . "</td><td>" . $row['name'] . "</td><td>" . $row['rollno'] . "</td><td>" . $row['emailid'] . "</td><td>" . $row['contact'] . "</td></tr>";  //$row['index'] the index here is a field name
	}

	echo "</table>";

?>
</div>

<?php
	require('../footer.php');
?>