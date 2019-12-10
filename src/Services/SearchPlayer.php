<?php
namespace App\Services;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Dotenv\Dotenv;
use Psr\Log\LoggerInterface;

class SearchPlayer
{
    const URL_GET_PLAYER_ID = "Destiny2/SearchDestinyPlayer/";

    public function __construct(LoggerInterface $logger)
    {
        $this->dotenv = new Dotenv();
        $this->dotenv->load(__DIR__.'\..\../.env');
        $this->logger = $logger;
    }

    public function getPlayerId(Int $plateforme, String $gamertag)
    {
        $this->logger->info(__CLASS__ . '->' . __FUNCTION__ . ' DEBUT');
        $url = $_ENV['URL_BUNGIE'] . self::URL_GET_PLAYER_ID . $plateforme . '/' . $gamertag;
        $client = HttpClient::create();
        $response = $client->request('POST', $url, [
            'headers' => [
                'X-Api-Key' => $_ENV['API_KEY']
            ],
        ]);
        return json_decode($response->getContent())->Response[0]->membershipId;       
    }

    public function getPlayerById(String $id, Int $plateforme)
    {
        $this->logger->info(__CLASS__ . '->' . __FUNCTION__ . ' DEBUT');
        $url = $_ENV['URL_BUNGIE'] . 'Destiny2/' . $plateforme . '/Profile/' . $id . '?Components=' . $_ENV['PLAYER_COMPONENTS'];
        $client = HttpClient::create();
		$response = $client->request('POST', $url, [
			'headers' => [
				'X-Api-Key' => $_ENV['API_KEY']
			],
        ]);
        return json_decode($response->getContent());
    }
}