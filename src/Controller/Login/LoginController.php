<?php
namespace App\Controller\Login;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Login;
use Psr\Log\LoggerInterface;

class LoginController extends AbstractController
{
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->login = new Login($logger);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        $this->logger->info(__CLASS__ . '->' . __FUNCTION__ . ' DEBUT');
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $this->login->getToken($code);
            return $this->redirectToRoute('homepage');
        }
        else {
            return $this->redirectToRoute('homepage');
        }       
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        $this->logger->info(__CLASS__ . '->' . __FUNCTION__ . ' DEBUT');
        session_start();
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        setcookie('access_token', "", time() - 3600);
        setcookie('refresh_token', "", time() - 3600);
        setcookie('membership_id', "", time() - 3600);

        return $this->redirectToRoute('homepage');
    }
}