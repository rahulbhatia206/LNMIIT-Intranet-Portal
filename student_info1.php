<?php
	require('../header.php');
	require('sidebar.php');
?>
<div id="contents"><b>
	<?php
	if(@$_SESSION['admin']==3)
	{
		if(isset($_GET['r_no']))
		{
			$roll_no = test_input($_GET['r_no']);
			$query = "SELECT `campus_student_info`.`Rollno`,`campus_student_info`.`Degreename`,`campus_student_info`.`Studname`,`campus_student_info`.`Emailid`,`campus_student_info`.`hostel no.`,`campus_student_info`.`room no.`,`campus_student_info`.`Studentmobile`,`campus_student_info`.`Fathername`,`campus_student_info`.`Fathermobile`,`warden_comments`.`comments` FROM `warden_comments` RIGHT JOIN `campus_student_info` ON `warden_comments`.`Rollno` = `campus_student_info`.`Rollno` WHERE `campus_student_info`.`Rollno`='$roll_no'";
			$query_run = mysql_query($query);
			if(mysql_num_rows($query_run)==1)
			{
				$row = mysql_fetch_assoc($query_run);
				if(isset($_POST['submit']))
				{
					$comments=test_input($_POST['comments']);
					if($comments=='')
					{
						$query = "DELETE FROM `warden_comments` WHERE `Rollno`='$roll_no'";
					}
					else if($row['comments']=='')
					{
					$query = "INSERT INTO `warden_comments` (`id`, `Rollno`, `comments`) VALUES (NULL, '$roll_no', '$comments')";
					}
					else{
						$query = "UPDATE `warden_comments` SET `comments` = '$comments' WHERE `Rollno` = '$roll_no'";
					}

					$query_run = mysql_query($query);

					echo "<script type='text/javascript'>window.location.href=window.location.href</script>";
				}
				if(isset($_POST['edit']))
				{
			?>
					<form method="post">
						Comments:<br>
						<textarea rows="5" cols="50" name="comments"><?php echo $row['comments']; ?></textarea>
						<input type="submit" value="submit" name="submit">
					</form>
			<?php
				}
				else{
				echo "<table border=1 style='width:90%;height:80%;border-collapse:collapse;text-align:center;'>";
				foreach($row as $key => $value)
				{
					echo "<tr><td>".$key."</td><td>".$value."</td></tr>";
				}
				echo "</table>";
				echo "<form method='post'><input type='submit' class='btn' style='margin-left:80%;margin-top:20px;'onmouseover=this.style.cursor='pointer' value='Edit' name='edit'></form>";
				}
			}
			else{
				echo "Incorrect Roll No.";
			}
		}
		else{
			echo "The page was interrupted.. Please go back and try again..";
		}
	}
	else{
		echo "YOU ARE NOT AUTHORIZED TO ACCESS THIS PAGE";
	}
	?>
</div>
<?php
	require('../footer.php');
?>