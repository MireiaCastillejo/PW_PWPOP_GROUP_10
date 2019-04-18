<?php
/**
 * Created by PhpStorm.
 * User: universidad
 * Date: 2019-04-18
 * Time: 12:29
 */
namespace SallePW\SlimApp\Controller\PostUserController;
use SallePW\SlimApp\Model\User;
use SallePW\SlimApp\Model\PostUserService;
use DateTime;

class PostUserController
{

    /**
     * @var service
     */
    private $service;

    public function __construct(PostUserService $service)
    {
        $this->service=$service;
    }

    //Creamos una funcion que te añade una tasca cuando clickas el boton
    public function taskAction($userName){


            if (isset($_POST['submit'])) {
                //Creamos una nueva tasca4¡
                $user = new User(0,$userName, $password, $email, $birthDate,new DateTime(),new DateTime());
                //Ejecutamos la tasca
                $this->service->execute($user);

            }

        try {
            //Enviamos los errores
            http_response_code(200);
        } catch (RenderException $e) {
            echo "An unexpected error has occurred, please try it again later.";
            http_response_code(500);
        }
    }
}
?>
}