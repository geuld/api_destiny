<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Exception;
use Psr\Log\LoggerInterface;
use App\Services\SearchPlayer;

class PlayerInfosController extends AbstractController
{
    public function __construct(LoggerInterface $logger)
    {
        $this->search = new SearchPlayer($logger);
        $this->logger = $logger;
    }

    /**
     * @Route("/player/{plateforme}/{gamertag}", name="player")
     */
    public function playerInfos($plateforme, $gamertag)
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