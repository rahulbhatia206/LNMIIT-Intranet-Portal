<?php

session_start();
mysql_connect('localhost','intranet','user@123');
mysql_select_db('intranet');
echo mysql_error();
      if(isset($_POST['submit1']))
      {
        if($_POST['approve']=='yes')
        {
          $approve=1;
        }
        else{
          $approve=0;
        }
        $remarks=$_POST['remarks'];
        $application=$_POST['application'];
        $query="UPDATE `campus_leave` SET `approved`=$approve,`remarks`='$remarks' WHERE `application_no`=$application";
        $query_run=mysql_query($query);
        echo "<h1>UPDATED</h1>";
        echo mysql_error();
        require 'PHPMailer/PHPMailerAutoload.php';
        if($approve==1)
        {
          $mbody="Approved <br> Remarks: ".$remarks;
        }
        else{
          $mbody="rejected <br> Remarks: ".$remarks;
        }
        $email_id=$_POST['email_id'];
 
    $mail = new PHPMailer;
 
    $mail->isSMTP();                                    
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth = true;                                 
    $mail->Username = 'intranet.lnmiit@gmail.com';                            
    $mail->Password = 'information.lnmiit';                        
    $mail->SMTPSecure = 'tls';                            
 
    $mail->From = 'noreply@gmail.com';  
    $mail->FromName = 'INTRANET LNMIIT';
    $mail->addAddress($email_id, 'Arush'); 
 
    $mail->addReplyTo('intranet.lnmiit@gmail.com', 'intranet lnmiit');
 
    $mail->WordWrap = 50;                                
    $mail->isHTML(true);                                  
 
    $mail->Subject = 'Leave Application Status';
    $mail->Body    = '<b>Your leave application is '.$mbody;
 
    if(!$mail->send()) {
      echo 'Message could not be sent.Error...';
      exit;
    }
    header('Location: approve.php');
    }
?>
