<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



function mailQR($to,$name, $attachment,$filename,$extra = null){
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        $mail->Host       = 'smtp.mail.yahoo.com';                     //Set the SMTP server to send through
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Username   = 'school_attendance12@yahoo.com';                     //SMTP username
        $mail->Password   = 'nwvnlcrxqbtwkgeh';                               //SMTP password
        $mail->setFrom('school_attendance12@yahoo.com', 'Student Management And Attendance Monitoring System');

        //Recipients
        $mail->addAddress($to, $name);     //Add a recipient
        $mail->addReplyTo('school_attendance12@yahoo.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        $mail->addAttachment($attachment, $filename.'.jpg');    //Optional name

        //Content
        $mail->Subject = 'You have been  registered!';
        $mail->Body    = 'You have been  registered in Student Management And Attendance Monitoring System <br> your qr code is attached below <br>'.$attachment . '<br>'.$extra;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        // echo 'Message has been sent';
    } catch (Exception $e) {
        // echo "Message could not be sent.";
    }
}

function mailSend($to,$name,$subject,$text){
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        $mail->Host       = 'smtp.mail.yahoo.com';                     //Set the SMTP server to send through
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Username   = 'school_attendance12@yahoo.com';                     //SMTP username
        $mail->Password   = 'nwvnlcrxqbtwkgeh';                               //SMTP password
        $mail->setFrom('school_attendance12@yahoo.com', 'Student Management And Attendance Monitoring System');

        //Recipients
        $mail->addAddress($to, $name);     //Add a recipient
        $mail->addReplyTo('school_attendance12@yahoo.com', 'Information');

        //Content
        $mail->Subject = $subject;
        $mail->Body    = $text;

        $mail->send();
        // echo 'Message has been sent';
    } catch (Exception $e) {
        // echo "Message could not be sent.";
    }
}
//Create an instance; passing `true` enables exceptions

