<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
require './Common/templateEmail.php';

class ControllerEmail {

  public function sendEmail($usuario,$filename) {
    $emailConfig = ModelEmail::getConfigEmail();
    if($emailConfig == null)
    {
      $data = array("mensaje" => "No existe una configuracion de correo para la aplicacion","statusCode" => 401 );
      echo json_encode($data);
      return;
    }
    else
    {
      $mail = new PHPMailer(true);
      try {
          $mail->CharSet = 'UTF-8';
          $mail->SMTPDebug = 0;// SMTP::DEBUG_SERVER;                      //Enable verbose debug output
          $mail->isSMTP();                                            //Send using SMTP
          $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
          $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
          $mail->Username   = $emailConfig[0]["email"];                  //SMTP username
          $mail->Password   = base64_decode($emailConfig[0]["password"]);                             //SMTP password
          $mail->SMTPSecure = 'tls';//PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
          $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

          //Recipients
          $mail->setFrom('gespinoza@formunica.com', 'Tomador de Pedidos');
          $mail->addAddress('gabrieljeg95@gmail.com', 'Gabriel EG');     //Add a recipient
          //$mail->addAddress('');               //Name is optional
          $mail->addReplyTo('info@example.com', 'Information');
          $mail->addCC('gabrieljeg2009@hotmail.com');
          //$mail->addBCC('bcc@example.com');

          //Attachments
          $mail->addAttachment('files/Logo.png');         //Add attachments
          $mail->addAttachment('files/'.$filename, 'pedido');    //Optional name

          //Content
          $mail->isHTML(true);                                  //Set email format to HTML
          $mail->Subject = 'Formunica-Tomador de Pedidos Honduras';
          $mail->Body    = template::getTemplate($usuario); //'This is the HTML message body <b>in bold!</b>';
          $mail->AltBody = 'Este correo a sido generado por sistema';

          $mail->send();
      } catch (\Exception $e) {
      }
    }
  }

  public function postEmailConfig($data) {
    if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$/",$data["email"]))
    {
      $data = array(
        "mensaje" => "Correo electrinico invalido",
        "statusCode" => 401
      );

      echo json_encode($data);
      return;
    }
    else
    {
      $email = ModelEmail::registerConfigEmail($data);
      echo $email;
      return;
    }

  }
}




 ?>
