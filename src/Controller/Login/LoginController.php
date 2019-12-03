<?php
namespace App\Controller\Login;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Login;
use App\Services\SearchPlayer;
use Psr\Log\LoggerInterface;

class LoginController extends AbstractController
{
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->login = new Login($logger);
        $this->search = new SearchPlayer($logger);
    }

    /**
     * @Route("/login")
     */
    public function login()
    {
        $this->logger->info(__CLASS__ . '->' . __FUNCTION__ . ' DEBUT');
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $token = $this->login->getToken($code);
            //$user = $this->login->getCurrentUser($token);
            // return $this->render('homepage.html.twig', [
            //     'displayName' => $user->Response->displayName
            // ]);
            return $this->redirectToRoute('homepage');
        }
        else {
            return $this->redirectToRoute('homepage');
        }       
    }
}