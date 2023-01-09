<?php
    require "captcha.php";
    require "./phpmailer/class.phpmailer.php";
    require "./phpmailer/mail_config.php";
    if (isset($_POST['email']) && isset($_POST['message'])) {
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
        session_start();
        if ($PHPCAP->verify($_POST["captcha"])){
            try{
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Mailer = 'smtp';
                $mail->SMTPDebug = 3;
                $mail->SMTPAuth = true;
                $mail->Host = 'smtp.gmail.com';
                $mail->Username = $username;
                $mail->Password = $password;
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                $mail->setFrom($_POST['email'], $_SESSION['name']);
                $mail->addAddress($username, 'Gheorghe Robert');
                $mail->Subject = 'Mail de la ' . $_SESSION['name'];
                $mail->AltBody = "View in HTML";
                $mail->MsgHTML($message);
                $mail->send();
                header("Location:contact.php?message=Mesaj trimis cu succes!");
            }
            catch (phpmailerException $e){
                header("Location:contact.php?message=Mesajul nu a putut fi trimis: {$e->errorMessage()}");
            }
            catch(Exception $e){
                header("Location:contact.php?message=Mesajul nu a putut fi trimis: {$e->getMessage()}");
            }
        }
        else
            header("Location:contact.php?errorcaptcha=Captcha incorect.");
}
?>
