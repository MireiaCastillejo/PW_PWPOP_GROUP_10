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
        $mail->Host = gethostbyname('in-v3.mailjet.com');

        //Credenciales del server de Mailjet
        $mail->Username = '5021eb82f2ee1e2c7655bee6f5b4206c';
        $mail->SMTPAuth = true;
        $mail->Password = 'e7e8dfc88688eaa52e2647e572d17041';

        $mail->SMTPSecure = 'ssl'; //tls 587, ssl 465
        $mail->Port = 465;
        //$mail->SMTPDebug = 2;

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );


        $mail->IsHTML(true);

        /* Open the try/catch block. */
        try {
            $hash = md5( rand(0,1000) );
            /* Set the mail sender. */
            $mail->setFrom('pwpopdreamteam@cyber-host.net', 'PWPOP Team');

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
