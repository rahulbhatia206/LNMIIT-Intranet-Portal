<?php
	require('../header.php');
	require('sidebar.php');
?>
    <div class="main-content">
        <div id="contents">
            <?php
            
            $roll=$_SESSION['username'];
      
      $query="SELECT * FROM `campus_student_info` WHERE `Rollno` = '$roll'";
      $query_run=mysql_query($query);
      mysql_error();
      $rows=mysql_num_rows($query_run);
      
      
      $row=mysql_fetch_assoc($query_run);
            
                $date = date_default_timezone_set('Asia/Kolkata');
                $today = date("d-m-y");

                if(isset($_POST['submit']))
                    {
                    $empty=0;
                    foreach($_POST as $key => $value)
                        {
                        if(!isset($value) || empty($value) || $_SERVER["REQUEST_METHOD"] != "POST")
                            {
                              echo "<center><b>********************************************************Please fill all the fields**************************************************</b></center>";
                              $empty=1;
                              break;
                            }
                        }
                  if($empty!=1)
                      {
                        
                        $roll_no=test_input($_SESSION['username']);
                        $date= $today;
                        $time_from=test_input($_POST['date_from']." ".$_POST['time_from']);
                        $time_to=test_input($_POST['date_to'])." ".test_input($_POST['time_to']);
                        $room_no=test_input($_POST['room_no']);
                        $mobile_student=test_input($_POST['mobile_student']);
                        $mobile_gaurdian=test_input($_POST['mobile_gaurdian']);
                        $reason1=test_input($_POST['reason1']);
                        $reason2=nl2br(test_input($_POST['reason2']));
                        $reason = ($reason1 . " ". $reason2) ; 
                        $query="SELECT `Emailid` , `Studname`FROM `campus_student_info` WHERE `Rollno`='$roll_no'";
                        $query_run=mysql_query($query);
                        $row=mysql_fetch_assoc($query_run);
                        $email=$row['Emailid'];
                        $name=$row['Studname'];

                         $query="INSERT INTO `campus_leave` (`application_no`, `name`, `roll_no`, `date`, `time_from`, `time_to`, `room_no`, `mobile_student`, `mobile_gaurdian`, `reason`, `email_id`) VALUES (NULL, '$name', '$roll_no', '$date', '$time_from', '$time_to', '$room_no', '$mobile_student', '$mobile_gaurdian', '$reason', '$email')";

                        $query_run=mysql_query($query);

                        $application_no=mysql_insert_id();
                        echo "<b><center>Your application no is: ".$application_no."</center></b><br>";

                        require 'PHPMailer/PHPMailerAutoload.php';

                        $mail = new PHPMailer;

                        $mail->isSMTP();                                    
                        $mail->Host = 'smtp.gmail.com'; 
                        $mail->SMTPAuth = true;                                 
                        $mail->Username = 'intranet.lnmiit@gmail.com';                            
                        $mail->Password = 'information.lnmiit';                        
                        $mail->SMTPSecure = 'tls';                            

                        $mail->From = 'noreply@gmail.com';  
                        $mail->FromName = 'INTRANET LNMIIT';
                        $mail->addAddress('ronakimod@gmail.com', 'Ronak'); 
                        $mail->addAddress($email, $name); 

                        $mail->addReplyTo('intranet.lnmiit@gmail.com', 'intranet lnmiit');
                        $mail->WordWrap = 50;                                
                        $mail->isHTML(true);                                  
 
                        $mail->Subject = 'Leave Application of '.$name;
                        $mail->Body    = '<b>Leave application form of '.$name.'</b><div><font color="blue"><br>
                        <font color="red">Application no.:</font>&nbsp;&nbsp;'.$application_no.'<br><br>
                          <font color="red">Name of Student</font>:&nbsp;&nbsp;'.$name.'<br><br><font color="red">Date:</font>&nbsp;&nbsp;'.$date.'<br><br>
                          <font color="red">Roll No.:</font>&nbsp;&nbsp;'.$roll_no.'<br><br><font color="red">Hostel and Hostel Room No:</font> &nbsp;&nbsp;'.$room_no.'<br><br><font color="red">Email: </font>&nbsp;&nbsp;<font color="pink">'.$email.'</font><br><br>
                          <font color="red">Mobile No. of Student:</font> &nbsp;&nbsp;
                          '.$mobile_student.'<br><br><font color="red">Mobile No. of Guardian:</font> &nbsp;&nbsp; '.$mobile_gaurdian.'<br><br>
                            <font color="red">Leave required from: </font>&nbsp;&nbsp;'.$time_from.'<br><br>
                          <font color="red">To (Will be back in campus):</font>&nbsp;&nbsp;'.$time_to.'<br><br>
                          <font color="red">Reason(s):</font><br><br>&nbsp;&nbsp;
                          '.$reason. '

                          </font>
                        </div>';
 
                if(!$mail->send()) 
                    {
                      echo '<b><center>Leave Application Couldnot be submitted.ERROR..</center></b>';
                      exit;
                    }

                    echo '<b><center>Leave Application is Submitted.</center></b>';

                    }
                }
            ?>


                <link rel="stylesheet" href="Zebra/default.css" type="text/css">
                <script type="text/javascript" src="Zebra/zebra_datepicker.js"></script>
                <script type="text/javascript">
                    $(document).ready(function () {

                        $('#dateto').Zebra_DatePicker({
                            direction: true
                        });
                        $('#datefrom').Zebra_DatePicker({
                            direction: true
                        });

                    });
                </script>



                <h1 class="body_title">Leave Application</h1>
                <?php if(!isset($_SESSION['id']) || @$_SESSION['admin']!=0)
                    {
                        die('<b>Please Login as a student To continue</b>');
                    }
	?>
                    <div class="form">
                        <form role="form" name="leave_application" method="post" action="leave_application.php">
                            <div class="col-lg-6">




                                <label for="InputName">Name of Student:</label>
                                <div class="input-group" >
                                    <b><?php echo    $row['Studname'];?></b>
                                </div><br>

                    <div class="form-group">
                            <label for="InputRoll">Roll No.</label>
                            <div class="input-group">
                                <b><?php echo    $row['Rollno'];?></b>
                            </div>
                        </div>

                                <br>
                                <tr>
                                    <td>Date:</td>
                                    <br>
                                    <td><b><?php echo $today; ?></b></td>
                                </tr>

                                <br>
                                <br> Hostel and Hostel Room No:

                                <input type="text" class="form-control" name="room_no" required> <br>Mobile No. of Student:

                                <input type="number" class="form-control" name="mobile_student" required> <br>Mobile No. of Guardian:

                                <input type="number" class="form-control" name="mobile_gaurdian" required>

                                <br>
                                <b>Leave required from (Leaving campus):</b> Date:
                                <input type="text" class="form-control" id="datefrom" name="date_from" required min="<?php echo $today; ?>"><br> Time:
                                <div class="input-group">
                                    <select class="select form-control" name="time_from">
                                        <option value="12:00 am">12:00 am</option>
                                        <option value="01:00 am">01:00 am</option>
                                        <option value="02:00 am">02:00 am</option>
                                        <option value="03:00 am">03:00 am</option>
                                        <option value="04:00 am">04:00 am</option>
                                        <option value="05:00 am">05:00 am</option>
                                        <option value="06:00 am">06:00 am</option>
                                        <option value="12:00 am">07:00 am</option>
                                        <option value="01:00 am">08:00 am</option>
                                        <option value="02:00 am">09:00 am</option>
                                        <option value="03:00 am">10:00 am</option>
                                        <option value="04:00 am">11:00 am</option>
                                        <option value="05:00 am">12:00 pm</option>
                                        <option value="06:00 am">01:00 pm</option>
                                        <option value="12:00 am">02:00 pm</option>
                                        <option value="01:00 am">03:00 pm</option>
                                        <option value="02:00 am">04:00 pm</option>
                                        <option value="03:00 am">05:00 pm</option>
                                        <option value="04:00 am">06:00 pm</option>
                                        <option value="05:00 am">07:00 pm</option>
                                        <option value="06:00 am">08:00 pm</option>
                                        <option value="12:00 am">09:00 pm</option>
                                        <option value="01:00 am">10:00 pm</option>
                                        <option value="01:00 am">11:00 pm</option>
                                       
                                    </select>
                                </div>
                               

                                <br>
                                <b>To (Will be back in campus):</b> Date:
                                <input type="text" class="form-control" id="dateto" name="date_to" required min="<?php echo $today; ?>"> <br>
                                
                                Time:
                                
                                <div class="input-group">
                                    <select class="select form-control" name="time_to">
                                        <option value="12:00 am">12:00 am</option>
                                        <option value="01:00 am">01:00 am</option>
                                        <option value="02:00 am">02:00 am</option>
                                        <option value="03:00 am">03:00 am</option>
                                        <option value="04:00 am">04:00 am</option>
                                        <option value="05:00 am">05:00 am</option>
                                        <option value="06:00 am">06:00 am</option>
                                        <option value="12:00 am">07:00 am</option>
                                        <option value="01:00 am">08:00 am</option>
                                        <option value="02:00 am">09:00 am</option>
                                        <option value="03:00 am">10:00 am</option>
                                        <option value="04:00 am">11:00 am</option>
                                        <option value="05:00 am">12:00 pm</option>
                                        <option value="06:00 am">01:00 pm</option>
                                        <option value="12:00 am">02:00 pm</option>
                                        <option value="01:00 am">03:00 pm</option>
                                        <option value="02:00 am">04:00 pm</option>
                                        <option value="03:00 am">05:00 pm</option>
                                        <option value="04:00 am">06:00 pm</option>
                                        <option value="05:00 am">07:00 pm</option>
                                        <option value="06:00 am">08:00 pm</option>
                                        <option value="12:00 am">09:00 pm</option>
                                        <option value="01:00 am">10:00 pm</option>
                                        <option value="01:00 am">11:00 pm</option>
                                       
                                    </select>
                                </div>

<br>
                                <b>Reason(s)</b>:
                                <select class="select form-control" name="reason1">
                                    <option value="Medical">Medical</option>
                                    <option value="Technical_Fest">Technical Fest</option>
                                    <option value="Cultsport">Cult./Sport Fest</option>
                                    <option value="Personal">Personal</option>
                                </select>
                                <br>
                                <textarea name="reason2" class="form-control" rows="7" cols="120" required>
                                </textarea>


                                <script>
                                    function myFunction() {
                                        confirm("You are about to submit an Application!");
                                    }
                                </script>
                                <input onclick="myFunction()" type="submit" name="submit" class="btnx btn" value="submit">
                            </div>
                        </form>




                    </div>


        </div>

        <?php
	
?>
    </div>
    <?php
	require('../footer.php');
?>