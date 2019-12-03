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
        try {
            $token = $this->login->ifSession();
            if (isset($token->Response->displayName)) {
                $currentUser = $this->login->getCurrentUser($token->access_token);
                return $this->render('homepage.html.twig', [
                    'displayName' => $currentUser->Response->displayName
                ]);
            }
            else {
                return $this->render('homepage.html.twig');
            }
        } catch (Exception $e) {
            $this->logger->error(__CLASS__ . '->' . __FUNCTION__ . ' => ' . $e->getMessage());
            return $this->redirectToRoute('homepage', ['error' => 1]);
        }
        
    }

    /**
     * @Route("/player/{plateforme}/{gamertag}", name="search_player")
     */
    public function searchPlayer(Int $plateforme, String $gamertag)
    {
        $this->logger->info(__CLASS__ . '->' . __FUNCTION__ . ' DEBUT');

        try {
            $id = $this->search->getPlayerId($plateforme, $gamertag);
            $player = $this->search->getPlayerById($id, $plateforme);
            return $this->render('playerInfos.html.twig', ['player' => $player]);
        } catch (Exception $e) {
            $this->logger->error(__CLASS__ . '->' . __FUNCTION__ . ' => ' . $e->getMessage());
            return $this->redirectToRoute('homepage', ['error' => 1]);
        }
    }
}