<?php
	require('../header.php');
	require('sidebar.php');
?>
    <script type="text/javascript">
        function printDiv(roll_no) {
            window.frames["print_frame"].document.body.innerHTML = '<h1>Leave Application of ' + roll_no + '</h1> <hr>' + document.getElementById('print').innerHTML;
            window.frames["print_frame"].window.focus();
            window.frames["print_frame"].window.print();
        }
    </script>
    <iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>
    <div id="contents"><b>
 	<h1 class="body_title">Leave Approval</h1>
 	  <?php
 	  if(!isset($_POST['sort']) || $_POST['sort']=='')
 	  {
 	    $_POST['sort']='Unapproved first';
 	  }
 	  if($_POST['sort']=='Approved first')
 	  {
 	    $query_part='ORDER BY `approved` DESC, ';
 	    $ap='selected';
 	    $uap='';
 	    $all='';
 	  }
 	  else if ($_POST['sort']=='Unapproved first')
 	  {
 	    $query_part='ORDER BY `approved`,';
 	    $uap='selected';
 	    $ap='';
 	    $all='';
 	  }
 	  else if($_POST['sort']=='Date')
 	  {
 	    $query_part='ORDER BY ';
 	    $all='selected';
 	    $ap=''; 
 	    $uap='';
 	  }

 	  if(isset($_SESSION['id']) and ((@$_SESSION['admin']==3) || (@$_SESSION['admin']==6)))
 	  {
 	    if(isset($_GET['a']))
 	    {
 	      echo "<div style='margin-bottom:10px;' id='print'><table  style='border-collapse:collapse;width:100%;' >";
 	      $application=test_input($_GET['a']);
 	          $query="SELECT * FROM `campus_leave` WHERE `application_no` = '$application'";

 	          $query_run=mysql_query($query);
 	          echo mysql_error();
 	          
 	          if(mysql_num_rows($query_run)==1){
 	            $row=mysql_fetch_assoc($query_run);
 	            foreach($row as $key=>$value)
 	            {
 	              if($key=="approved")
 	              {
 	                if($value==0)
 	                {
 	                  echo "<tr><td>$key:</td> <td>No</td></tr>";
 	                }
 	                else{
 	                  echo "<tr><td>$key:</td> <td>Yes</td></tr>";
 	                }
 	              }
 	              else{
 	                echo "<tr><td>$key:</td> <td>$value</td></tr>";
 	              }
 	            }
 				echo "<button onclick='printDiv(\"$row[roll_no]\");';>Print</button><br><br>";
 				

 	          if ($row['approved']==0)
 	          {
 	      ?>
 	    </table>
 	      <form method="post" action="approve1.php">
 	        <br><br>approve?<input type="radio" name="approve" value="yes">YES&nbsp;&nbsp;&nbsp;<input type="radio" name="approve" value="no">NO<br><br>
 	        remarks:<input type="text" name="remarks"><br><br>
 	        <input type="hidden" value=<?php echo $application; ?> name="application">
 	        <input type="hidden" value=<?php echo $row['email_id']; ?> name="email_id">
 	        <input type="submit" name="submit1" value="submit"><br><br><br>
 	      </form>
 	      <?php
 	          }
 	        }
 	        else
 	        {
 	          echo "incorrect application id";
 	        }
 	        echo "</div>";
 	      }
 	      else{

 	  ?>
 	  <div>
 	    <form method="post">
 	     SORT BY:<select name="sort"><br><br>
 	      <option value="Unapproved first" <?php echo $uap;?>>Unapproved</option>
 	      <option value="Approved first" <?php echo $ap;?>>Approved</option>
 	      <option value="Date" <?php echo $all;?>>Date</option>
 	    </select>
 	    <input type="submit" name="go" value="go">
 	  </form><br>
 	  </div>
 	  <table class="leavetable" border=1 style="text-align:center;border-collapse:collapse;"width="100%">
 	    <tr><th>Application No</th><th>Name</th><th>Roll No</th><th>FROM</th><th>TO</th><th>DATE</th><th>Approved</th></tr>
 	  <?php
 	  $query="SELECT `application_no` ,`name`,`roll_no`,`time_from`, `time_to`, `date`, `approved` FROM `campus_leave` ".$query_part." `date` DESC";
 	  $query_run=mysql_query($query);

 	  while($row=mysql_fetch_assoc($query_run))
 	  {
 	    if($row['approved']==1)
 	    {
 	      $a='YES';
 	    }
 	    else{
 	      $a='No';
 	    }
 	    print "<tr><td><a href=?a=".$row['application_no'].">".$row['application_no']."</a></td>
        <td>".$row['name']."</td><td>".$row['roll_no']."</td><td>".$row['time_from']."</td><td>".$row['time_to']."</td>
        <td>".$row['date']."</td><td>".$a."</tr>";
 	  } 
 	  }
 	  echo "</table>";

 	}
 	else
    {
 		echo "<h3>Access Denied</h3>";
 		echo "You are not authorized to access this part of website<br><br><br>";
 		
 	}


 	  ?>

</div>
</div>
<?php
	require('../footer.php');
?>