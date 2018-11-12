<?php

require("phpmailer/phpmailer.php");
require("phpmailer/SMTP.php");
require("phpmailer/Exception.php");

//sendpasswordreset("walter.rivera@kegel.net");


function sendpasswordreset($email,$newpassword){
  $status = false;

  // The message
  $message = "Line 1\r\nLine 2\r\nLine 3";

  // In case any of our lines are larger than 70 characters, we should use wordwrap()
  $message = wordwrap($message, 70, "\r\n");
  $account = "rivera.texidor@gmail.com";
  $password = "Walter01$";

  $to=$email;
  $from="walter.rivera@kegel.net";
  $from_name="Kegel LaneMapper Team";
  $msg="
  Your account password has been reset.<br>
  Please use the following partial password to access lanemapper.<br><br>
  Password: ".$newpassword."<br><br><br>
  <strong>This is an automated message. Please do not reply.</strong>"; // HTML message
  $subject="LaneMapper Password Reset";

  $mail = new PHPMailer\PHPMailer\PHPMailer(true);
  $mail->IsSMTP();
  $mail->CharSet = 'UTF-8';
  $mail->Host = "smtp.gmail.com";
  $mail->SMTPAuth= true;
  $mail->Port = 465;
  $mail->Username= $account;
  $mail->Password= $password;
  $mail->SMTPSecure = 'ssl';
  $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
          )
      );
  $mail->From = $from;
  $mail->FromName= $from_name;
  $mail->isHTML(true);
  $mail->Subject = $subject;
  $mail->Body = $msg;
  $mail->addAddress($to);

  if(!$mail->send()){
   //echo "Mailer Error: " . $mail->ErrorInfo;
  }else{
   $status = true;
  }

  return $status;
}




?>
