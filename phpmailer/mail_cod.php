<?php

//sursa: https://github.com/PHPMailer/PHPMailer
//tutorial: https://alexwebdevelop.com/phpmailer-tutorial/
//Gmail restriction: https://support.google.com/mail/answer/22370?hl=en

require_once('class.phpmailer.php');
require_once('mail_config.php');

// Mesajul
$message = "Line 1 Line 2 Line 3";

// În caz că vre-un rând depășește N caractere, trebuie să utilizăm
// wordwrap()
$message = wordwrap($message, 6, "<br />\n");


$mail = new PHPMailer(true); 

$mail->IsSMTP();

try {
 
  $mail->SMTPDebug  = 3;                     
  $mail->SMTPAuth   = true; 

  $to='vslsilviu@gmail.com';
  $nume='Silviu Vasile';

  $mail->SMTPSecure = "ssl";                 
  $mail->Host       = "smtp.gmail.com";      
  $mail->Port       = 465;                   
  $mail->Username   = $username;  			// GMAIL username
  $mail->Password   = $password;            // GMAIL password
  $mail->AddReplyTo('moscraciun@gmail.com', 'Mos Craciun');
  $mail->AddAddress($to, $nume);
 
  $mail->SetFrom('moscraciun@gmail.com', 'Mos Craciun');
  $mail->Subject = 'Cadou';
  $mail->AltBody = 'To view this post you need a compatible HTML viewer!'; 
  $mail->MsgHTML($message);
  $mail->Send();
  echo "Message Sent OK</p>\n";
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //error from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //error from anything else!
}
?>
