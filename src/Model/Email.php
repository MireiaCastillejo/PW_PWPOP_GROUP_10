<?php
/**
 * Created by PhpStorm.
 * User: Judit
 * Date: 04/05/2019
 * Time: 18:16
 */

namespace SallePW\SlimApp\Model;

/* Namespace alias. */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;





class Email


{

    public function sendEmail(string $useremail){


        /* Creamos la clase y añadimos el host, el username y la contraseña del servidor SMTP*/
        $mail = new PHPMailer(TRUE);
        $mail->IsSMTP(true);
        $mail->Host = gethostbyname('tls://smtp.eu.sparkpostmail.com');

        //Credenciales del server de Mailjet
        $mail->Username = 'SMTP_Injection';
        $mail->SMTPAuth = true;
        $mail->Password = '3ff70987ea813a1599994694edc9fc6b99262a77';

        $mail->SMTPSecure = 'tls'; //tls 587, ssl
        $mail->SMTPAutoTLS = false;
        $mail->Port = 2525;
        //$mail->SMTPDebug = 2;

        /*$mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );*/


        $mail->IsHTML(true);

        /* Open the try/catch block. */
        try {
            $hash = md5( rand(0,1000) );
            /* Set the mail sender. */
            $mail->setFrom('pwpopdreamteam@hotmail.com', 'PWPOP Team');

            /* Add a recipient. */
            $mail->addAddress($useremail);

            /* Set the subject. */
            $mail->Subject = 'Verification';

            /* Set the mail message body. */
            $mail->Body = 'Thanks for signing up!
            Your account has been created, you can login after you have activated your account by pressing the url below.

            

            Please click this link to activate your account:
            <a href ="http://pwpop.test/verify?email='.$useremail.'&hash='.$hash.'">www.pwpop.test/verify</a>
            
             
            ';

            /* Finally send the mail. */
            $mail->send();
        }
        catch (Exception $e)
        {
            /* PHPMailer exception. */
            echo $e->errorMessage();
        }
        catch (\Exception $e)
        {
            /* PHP exception (note the backslash to select the global namespace Exception class). */
            echo $e->getMessage();
        }

    }


}
