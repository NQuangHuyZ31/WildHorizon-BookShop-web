<?php

namespace Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';
class SendMail
{
  public static function sendOTP($email, $customer, $otp, $content)
  {
    // Khởi tạo
    $mail = new PHPMailer(true);

    try {
      //Server settings
      // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
      $mail->isSMTP();                                            //Send using SMTP
      $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $mail->Username   = 'huynguyenharu3108@gmail.com';                     //SMTP username
      $mail->Password   = 'mfuk uxvq ykdy stst';                               //SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
      $mail->Port       = 465;
      $mail->CharSet = 'UTF-8';          // ✅ xử lý tiếng Việt
      $mail->Encoding = 'base64';        // hoặc 'quoted-printable'                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

      //Recipients
      $mail->setFrom('huynguyenharu3108@gmail.com', 'Wild Horizon BookShop');
      $mail->addAddress($email, $customer);     //Add a recipient
      // $mail->addAddress('ellen@example.com');               //Name is optional
      $mail->addReplyTo('huynguyenharu3108@gmail.com', 'Wild Horizon BookShop');
      // $mail->addCC('cc@example.com');
      // $mail->addBCC('bcc@example.com');

      //Attachments
      // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
      // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

      //Content
      $mail->isHTML(true);                                  //Set email format to HTML
      $mail->Subject = $content;
      $mail->Body = '<p style="font-size: 20px; font-weight: 600;">Mã xác minh của bạn: <span style="font-size: 30px; font-weight: 600;">' . $otp . '</span></p>
      <p>Làm ơn không tiết lộ trong bất kì hình thức nào để đảm bảo an toàn cho bạn.</p>
      <p>Đây là mã xác minh để ' . $content . '. Vui lòng đảm bảo xác minh trong vòng <strong>5 phút</strong>.</p>';
      $mail->send();
      return true;
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  }
}
