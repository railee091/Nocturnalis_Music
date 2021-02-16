<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['subscribeName']) && isset($_POST['subscribeEmail'])) {
    
    $senderName = $_POST['subscribeName'];
    $senderEmail = $_POST['subscribeEmail'];
    $senderMessage = "Subscribe to email-list:<br/>".$senderName."<br/>".$senderEmail;
    }else{
       header('location:index');
    }

require_once __DIR__ . '/phpmailer/src/Exception.php';
require_once __DIR__ . '/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/phpmailer/src/SMTP.php';

// passing true in constructor enables exceptions in PHPMailer
$mail = new PHPMailer(true);
$senderName = $_POST['subscribeName'];
$senderEmail = $_POST['subscribeEmail'];
$senderMessage = "<b>".$senderName."</b> you are now subscribed to our mail list using your email address <br/> 
                                <b>".$senderEmail."</b>
and will recieve future updates for exclusive content <a href='http://www.nocturnalis.com/' >Nocturnalis Music</a>";

try {
    // Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    require_once('emailkeys/emailpasswords.php');

    // Sender and recipient settings
    $mail->setFrom($websiteEmailAddress, 'Nocturnalis Music');
    $mail->addAddress($senderEmail, 'subscriberMailList-'.$senderName);//set their name
    $mail->addReplyTo($senderEmail, $senderName); // to set the reply to

    // Setting the email content
    $mail->IsHTML(true);
    $mail->Subject = "Subscribed to Nocturnalis news";
    $mail->Body = $senderMessage;//'HTML message body. <b>Gmail</b> SMTP email body.';
    $mail->AltBody = $senderMessage;//'Plain text message body for non-HTML email client. Gmail SMTP email body.';

    $mail->send();
    header('location:index');
    //echo "Email message sent.";
} catch (Exception $e) {
    header('location:index');
    //echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
}

 $txt = $senderEmail;
 $myfile = file_put_contents('3m@1Lk3y5/Subscriber_3m@1L_L15t.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
session_destroy ();
?>