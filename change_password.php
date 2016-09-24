<?php
	require('../header.php');
?>
<div id="contents"><b>
 	<h1 class="body_title">Change Password</h1>
 	<?php
 if(isset($_POST['change_password']))
 {
   if(!empty($_POST['username']) && !empty($_POST['old_password']) && !empty($_POST['new_password']) && !empty($_POST['repeat_new_password']))
   {
     if($_POST['new_password']==$_POST['repeat_new_password'])
     {
       $username=$_POST['username'];
       $password=$_POST['old_password'];
       $newpassword=$_POST['new_password'];
       $query="UPDATE `login_info` SET `password`='$newpassword' WHERE `username`='$username' AND `password`='$password'";
       $query_run=mysql_query($query) or die(mysql_error());
       if (mysql_affected_rows()==0)
        {
          print "Either The Username or Password is Incorrect <br> Or You didnot change the Password";
        }
        else if(mysql_affected_rows()==1)
        {
          echo "Your Password Has Been Updated";
        }
      }
     else{
       echo "New Password and Repeat New Password donot match";
      }
   }
   else{
     echo "Please fill in all the fields";
   }
 }
 ?>
</b><br><br>


	<form method="post" name="change_password" action="change_password.php">
  <table>
    <tr><td>Username:</td><td><input type="text" name="username" /></td></tr>
    <tr><td>Old Password:</td><td><input type="password" name="old_password" /></td></tr>
    <tr><td>New Password:</td><td><input type="password" name="new_password" /></td></tr>
    <tr><td>Repeat New Password:</td><td><input type="password" name="repeat_new_password" /></td></tr>
    <tr><td></td><td><input type="submit" name="change_password" value="Change Password" /></td></tr>
  </table>
  </form>
</div>

<?php
	require('../footer.php');
?>