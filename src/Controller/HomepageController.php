<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\SearchPlayer;
use Exception;
use Psr\Log\LoggerInterface;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render('homepage.html.twig');
    }

    /**
     * @Route("/player/{plateforme}/{gamertag}", name="search_player")
     */
    public function searchPlayer(Int $plateforme, String $gamertag, LoggerInterface $logger)
    {
        $logger->info(__CLASS__ . '->' . __FUNCTION__ . ' DEBUT');

        $search = new SearchPlayer();

        try {
            $id = $search->getPlayerId($plateforme, $gamertag);
            $player = $search->getPlayerById($id, $plateforme);
            return $this->render('playerInfos.html.twig', ['player' => $player]);
        } catch (Exception $e) {
            $logger->error(__CLASS__ . '->' . __FUNCTION__ . ' => ' . $e->getMessage());
            return $this->redirectToRoute('homepage', ['error' => 1]);
        }
    }
}