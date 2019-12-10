<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\SearchPlayer;
use App\Services\Login;
use Exception;
use Psr\Log\LoggerInterface;

class HomepageController extends AbstractController
{
    public function __construct(LoggerInterface $logger)
    {
        $this->login = new Login($logger);
        $this->search = new SearchPlayer($logger);
        $this->logger = $logger;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $this->logger->info(__CLASS__ . '->' . __FUNCTION__ . ' DEBUT');
        if (isset($_COOKIE['refresh_token'])) { 
            session_start();           
            try {
                $displayName = $this->login->getDisplayName();
                return $this->render('homepage.html.twig', [
                   'displayName' => $displayName
                ]);
            } catch (Exception $e) {
                $this->logger->error(__CLASS__ . '->' . __FUNCTION__ . ' => ' . $e->getMessage());
                return $this->redirectToRoute('homepage', ['error' => 1]);
            }
        }
        return $this->render('homepage.html.twig');        
    }

    /**
     * @Route("/searchPlayer", name="search_player")
     */
    public function searchPlayer()
    {
        $this->logger->info(__CLASS__ . '->' . __FUNCTION__ . ' DEBUT');
        
        if (isset($_POST['search'])) {
            $plateforme = $_POST['plateforme'];
            $gamertag = $_POST['gamertag'];
            return $this->redirectToRoute('player', ['plateforme' => $plateforme, 'gamertag' => $gamertag]);
        }
        else {
            return $this->redirectToRoute('homepage');
        }
    }
}