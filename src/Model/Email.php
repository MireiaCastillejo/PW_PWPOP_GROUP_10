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
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use SallePW\SlimApp\Controller\HelloController;

use SallePW\SlimApp\Model\Database\PDORepository;



class Email


{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    public function sendEmail(string $useremail){



        /* Creamos la clase y añadimos el host, el username y la contraseña del servidor SMTP*/
        $mail = new PHPMailer(TRUE);
        $mail->IsSMTP(true);
        $mail->Host = gethostbyname('tls://smtp.eu.sparkpostmail.com');

        //Credenciales del server de Mailjet
        $mail->Username = 'SMTP_Injection';
        $mail->SMTPAuth = true;
        $mail->Password = '45c90477d4c9b27fdc9bd973b59137fbc3be84e6';

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


    public function reSendEmail(){


        /** @var PDORepository $repository**/
        $repository = $this->container->get('user_repo');

        $id = (int)$_SESSION['user_id'];
        $useremail = $repository->getEmail($id);

        /* Creamos la clase y añadimos el host, el username y la contraseña del servidor SMTP*/
        $mail = new PHPMailer(TRUE);
        $mail->IsSMTP(true);
        $mail->Host = gethostbyname('tls://smtp.eu.sparkpostmail.com');

        //Credenciales del server de Mailjet
        $mail->Username = 'SMTP_Injection';
        $mail->SMTPAuth = true;
        $mail->Password = '45c90477d4c9b27fdc9bd973b59137fbc3be84e6';

        $mail->SMTPSecure = 'tls'; //tls 587, ssl
        $mail->SMTPAutoTLS = false;
        $mail->Port = 2525;



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

    public function sendEmailToOwner(Request $request, Response $response,$ide): Response{



        /** @var PDORepository $repository**/
        $repository_u = $this->container->get('user_repo');
        $repository_p = $this->container->get('product_repo');

        $idprod = (int)$ide['id'];

        $idowner= $repository_p->getOwnerId($idprod);
        $ownerEmail = $repository_u->getEmail($idowner);

        $idbuyer = (int)$_SESSION['user_id'];


        $buyerInfo['phonenumber'] = $repository_u->getPhone($idbuyer);
        $var = $repository_u->getUsername($idbuyer);
        $buyerInfo['username'] = $var['username'];



        /* Creamos la clase y añadimos el host, el username y la contraseña del servidor SMTP*/
        $mail = new PHPMailer(TRUE);
        $mail->IsSMTP(true);
        $mail->Host = gethostbyname('tls://smtp.eu.sparkpostmail.com');

        //Credenciales del server de Mailjet
        $mail->Username = 'SMTP_Injection';
        $mail->SMTPAuth = true;
        $mail->Password = '45c90477d4c9b27fdc9bd973b59137fbc3be84e6';

        $mail->SMTPSecure = 'tls'; //tls 587, ssl
        $mail->SMTPAutoTLS = false;
        $mail->Port = 2525;



        $mail->IsHTML(true);

        /* Open the try/catch block. */
        try {

            /* Set the mail sender. */
            $mail->setFrom('pwpopdreamteam@hotmail.com', 'PWPOP Team');

            /* Add a recipient. */
            $mail->addAddress($ownerEmail);

            /* Set the subject. */
            $mail->Subject = 'GOOD NEWS NOOB';

            /* Set the mail message body. */
            $mail->Body = 'Someone wants to buy your shit! <br/>
            
            You can contact your buyer here: <br/>
             <br/>
            Username: '.$buyerInfo['username'].' <br/>
            Phone number: '.$buyerInfo['phonenumber'].' <br/>
             <br/>
             <br/>
            Thank you for using our wonderful service. Viva Cuba Libre :) <br/>
                
           <br/> 
           <br/> 
           <br/>

            

            The PWPOP Dream Team
            
             
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




        return $response->withStatus(201);
    }
}
