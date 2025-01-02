<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {

  header('Content-type: application/json');
  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);
  $datos = ($request);

  $correo = $datos->correo;
  $mensaje = $datos->mensaje;;



    echo  $correo;
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'matriculate@corp.umc.cl';                     //SMTP username
    $mail->Password   = 'pkwl qywn ugvg gkid';
    //$mail->Password   = '@umc0370p7@';  
    $mail->SMTPSecure ='ssl';            //Enable implicit TLS encryption
    $mail->Port       = 465;                              //SMTP password
    /*$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;*/                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('matriculate@corp.umc.cl', 'Admisión');
   // $mail->addAddress('cesarinfo10@gmail.com', 'CASV');   .
    $mail->addAddress($correo, '');   //Add a recipient
   /* $mail->addAddress('ellen@example.com'); 
                  //Name is optional
    $mail->addReplyTo('info@example.com', 'Information');*/
    $mail->addCC('cecheverria@corp.umc.cl');
    /*$mail->addBCC('bcc@example.com');*/

    //Attachments
    /*
    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');  */  //Optional name

    //Content
    $mail->isHTML(true);
    $mail->CharSet= 'UTF-8';                                //Set email format to HTML
    $mail->Subject = 'Admisión';
    $mail->Body    = '<!DOCTYPE html>
    <html style="text-align: -webkit-center;">  
      <head>
        <meta http-equiv="Content-Type" content="text/html;  http-equiv="content-type" charset="utf-8" /> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css"rel="stylesheet" type="text/css">
      </head>
  <body style="text-align: -webkit-left;">
        <img src="https://admision.umcervantes.cl/wp-content/uploads/2023/10/logo-universidad-miguel-de-cervantes-umc.png" style="width:25%;"/>		
        <hr/>
           <h4 style="margin-bottom:5px"></h4>
           <h4 style="margin-bottom:5px">'.$mensaje.'</h4>
           <h4 style="margin-bottom:5px"></h4>
           <br/>
           <br/>
        <hr/>
        <h5>
        ENRIQUE MAC IVER 370, SANTIAGO DE CHILE. <br/>
        UNIVERSIDAD MIGUEL DE CERVANTES. TODOS LOS DERECHOS RESERVADOS.
        <br/>
        CONTÁCTANOS +56 229273401/ 229273402
        </h5>
        <br>
        <center><a href="https://www.umcervantes.cl/"><button type="submit" class="btn btn-primary" style="margin-bottom:50px;color: #ffffff;background-color: #286193;border-color: #204f77;display: inline-block; margin-bottom: 0;font-weight: normal;text-align: center;vertical-align: middle;touch-action: manipulation;cursor: pointer;background-image: none;border: 1px solid transparent;white-space: nowrap;padding: 6px 12px;font-size: 14px;line-height: 1.42857143;border-radius: 4px;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;">IR A UMCERVANTES.CL</button></a></center>
        <br>
        <center><a href="https://matriculate.umc.cl/"><button type="submit" class="btn btn-primary" style="margin-bottom:50px;color: #ffffff;background-color: #286193;border-color: #204f77;display: inline-block; margin-bottom: 0;font-weight: normal;text-align: center;vertical-align: middle;touch-action: manipulation;cursor: pointer;background-image: none;border: 1px solid transparent;white-space: nowrap;padding: 6px 12px;font-size: 14px;line-height: 1.42857143;border-radius: 4px;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;">IR AL LOGIN</button></a></center>
        </body>
</html> ';
    
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Enviado Correctamente';
} catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
}