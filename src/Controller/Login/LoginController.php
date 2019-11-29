<?php
namespace App\Controller\Login;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Login;

class LoginController extends AbstractController
{
    /**
     * @Route("/login")
     */
    public function login()
    {
        if (isset($_GET['code'])) {
            $code = $_GET['code'];

            $login = new Login();
            $token = $login->getToken($code);

            print_r($token);

            return new Response('');
        }
    }

    /**
     * @Route("/refresh")
     */
    public function refreshToken()
    {
        if (isset($_COOKIE['refresh_token'])) {
            $refresh = $_COOKIE['refresh_token'];
            $login = new Login();
            $refresh_token = $login->refresh($refresh);
        }
    }
}