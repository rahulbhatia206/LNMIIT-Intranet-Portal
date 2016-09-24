<?php
	require('../header.php');
	require('sidebar.php');
?>

    <div class="main-content">
        <div id="contents">

            <h1 class="body_title">Student Information</h1>
            <?php


 	function add3dots($string, $repl, $limit) 
 	{
 	  if(strlen($string) > $limit) 
 	  {
 	    return substr($string, 0, $limit) . $repl; 
 	  }
 	  else 
 	  {
 	    return $string;
 	  }
 	}









 if(isset($_SESSION['id']))
 {
 	if(isset($_GET['y']))
 	{
 		$y=test_input($_GET['y']);
 		if(@$_SESSION['admin']==3)
 		{
 			$query="SELECT `campus_student_info`.`Rollno`,`campus_student_info`.`Degreename`,`campus_student_info`.`Studname`,`campus_student_info`.`Emailid`,`campus_student_info`.`hostel no.`,`campus_student_info`.`room no.`,`campus_student_info`.`Studentmobile`,`campus_student_info`.`Fathername`,`campus_student_info`.`Fathermobile`,`warden_comments`.`comments` FROM `warden_comments` RIGHT JOIN `campus_student_info` ON `warden_comments`.`Rollno` = `campus_student_info`.`Rollno` WHERE `year`='$y' ORDER BY `campus_student_info`.`Degreename`,`campus_student_info`.`Rollno`";
 		}
 		else{
 			$query="SELECT `Degreename`,`Rollno`,`Studname`,`Emailid`,`hostel no.`,`room no.` FROM `campus_student_info` WHERE `year`='$y' ORDER BY `Degreename`,`Rollno`";
 		}
 	
 		echo mysql_error();
 		$query_run=mysql_query($query);
 		echo mysql_error();
 		if(mysql_num_rows($query_run)>0)
 		{

 		?>
                <table>
                    <tr>
                        <th>Sr.no</th>
                        <th>Degree</th>
                        <th>Roll No.</th>
                        <th>Name</th>
                        <th>Email id</th>
                        <th>hostel</th>
                        <th>Room No</th>
                        <?php if(@$_SESSION['admin']==3){echo "<th>Student Mobile</th><th>Father Name</th><th>Father Mobile</th><th>Comments</th>";}?>
                    </tr>
                    <?php
 		$count=1;
 		while($row=mysql_fetch_assoc($query_run))
 		{
 			if(@$_SESSION['admin']==3)
 			{
 				$page_link = "onclick=window.document.location='student_info1.php?r_no=".$row['Rollno']."' onmouseover=this.style.cursor='pointer'";
 			}
 			else{
 				$page_link = "";
 			}
 			echo "<tr ".$page_link."><td>".$count."</td>";
 			$count++;
 			$row['comments']=add3dots($row['comments'], "...", 12);
 			foreach($row as $key => $value)
 			{

 				echo "<td>".$value."</td>";	
 			}
 			echo "</tr>";
 		}
 		}
 	}
 	else
 	{
 	?>
                        <div class="links">
                            <ul>
                                <li><a href="?y=y15" target="_self">UG y15</a></li>
                                <br>
                                <li><a href="?y=y14" target="_self">UG y14</a></li>
                                <br>
                                <li><a href="?y=y13" target="_self">UG y13</a></li>
                                <br>
                                <li><a href="?y=y12" target="_self">UG y12</a></li>
                                <br>
                                <li><a href="?y=pg" target="_self">PG students</a></li>
                                <br>
                            </ul>
                        </div>
                        <?php
 	}
 }
 else{
 	echo "please login to continue" ;
 }
 	?>
                </table>

        </div>
        <?php
	
?>
    </div>
    <?php
	require('../footer.php');
?>