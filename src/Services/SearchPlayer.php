<?php
namespace App\Services;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Dotenv\Dotenv;

class SearchPlayer
{
    const URL_GET_PLAYER_ID = "Destiny2/SearchDestinyPlayer/";

    public function __construct()
    {
        $this->_dotenv = new Dotenv();
        $this->_dotenv->load(__DIR__.'\..\../.env');
    }

    public function getPlayerId(Int $plateforme, String $gamertag)
    {
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