<?php
namespace App\Controller\Login;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Login;
use Psr\Log\LoggerInterface;

class LoginController extends AbstractController
{
    /**
     * @Route("/login")
     */
    public function login(LoggerInterface $logger)
    {
        $logger->info(__CLASS__ . '->' . __FUNCTION__ . ' DEBUT');
        if (isset($_GET['code'])) {
            $code = $_GET['code'];

            $login = new Login();
            $token = $login->getToken($code);print_r($token);die;

            return $this->render('homepage.html.twig');
        }
        else {
            return $this->redirectToRoute('homepage');
        }       
    }

    // /**
    //  * @Route("/refresh")
    //  */
    // public function refreshToken()
    // {
    //     if (isset($_COOKIE['refresh_token'])) {
    //         $refresh = $_COOKIE['refresh_token'];
    //         $login = new Login();
    //         $refresh_token = $login->refresh($refresh);
    //     }
    // }
}