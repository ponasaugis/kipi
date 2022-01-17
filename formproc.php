<?php
if (!isset($_POST['name']) || !isset($_POST['phone']) || !isset($_POST['message']) || !isset($_POST['email'])){
    exit;
}
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

$data = [];

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    //$mail->isSMTP();                                            //Send using SMTP
    //$mail->Host = 'smtp.example.com';                     //Set the SMTP server to send through
    //$mail->SMTPAuth = true;                                   //Enable SMTP authentication
    //$mail->Username = 'user@example.com';                     //SMTP username
    //$mail->Password = 'secret';                               //SMTP password
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    //$mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom("prekyba@kipi.lt", "kipi svetaine");
    $mail->addAddress('prekyba.kipi@gmail.com', 'Kliento klausimas');     //Add a recipient
    //$mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('prekyba@kipi.lt', 'KIPI');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
   // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Kliento klausimas';
    $mail->Body = "Kliento klausimas: <b>kipi.lt</b> <br><br>" . $_POST['name'] . "<br>" . $_POST['phone'] . "<br>" . $_POST['email'] . "<br><hr>" . $_POST['message'];
    $mail->AltBody = "";

    $mail->send();
    $data['success'] = true;
    $data['message'] = "Sėkmingai išsiųsta!";
    echo json_encode($data);
} catch (Exception $e) {
    $data['success'] = false;
    $data['errors'] = $mail->ErrorInfo;
    echo json_encode($data);
}