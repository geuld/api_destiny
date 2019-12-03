<?php
namespace App\Services;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Dotenv\Dotenv;
use Psr\Log\LoggerInterface;

class Login 
{
	public function __construct(LoggerInterface $logger)
	{
		$this->_dotenv = new Dotenv();
        $this->_dotenv->load(__DIR__.'\..\../.env');
		$this->logger = $logger;
	}

    public function getToken($code = '')
    {
		$this->logger->info(__CLASS__ . '->' . __FUNCTION__ . ' DEBUT');
		if (!isset($_COOKIE['refresh_token'])) {
			$client = HttpClient::create();
			$response = $client->request('POST', $_ENV['URL_TOKEN'], [
				'headers' => [
					'Content-Type' => 'application/x-www-form-urlencoded',
					'Authorization' => 'Basic ' . base64_encode($_ENV['CLIENT_ID'] . ":" . $_ENV['SECRET_TOKEN'])
				],
				'body' => [
					'grant_type' => 'authorization_code',
					'code' => $code
				],
			]);
			$this->setCookies(json_decode($response->getContent()));
			return json_decode($response->getContent());
		}
		else {
			$client = HttpClient::create();
			$response = $client->request('POST', $_ENV['URL_TOKEN'], [
				'headers' => [
					'Content-Type' => 'application/x-www-form-urlencoded',
					'Authorization' => 'Basic ' . base64_encode($_ENV['CLIENT_ID'] . ":" . $_ENV['SECRET_TOKEN'])
				],
				'body'=> [
					'grant_type' => 'refresh_token',
					'refresh_token' => $_COOKIE['refresh_token']
				],
			]);			
			$this->setCookies(json_decode($response->getContent()));
			return json_decode($response->getContent());
		}
	}
	
	public function setCookies($response)
	{
		$this->logger->info(__CLASS__ . '->' . __FUNCTION__ . ' DEBUT');
		setCookie("access_token", $response->access_token, time() + intval($response->expires_in));
		setCookie("refresh_token", $response->refresh_token, time() + intval($response->refresh_expires_in));
		setCookie("membership_id", $response->membership_id, time() + intval($response->refresh_expires_in));
	}

	public function ifSession() 
	{
		$this->logger->info(__CLASS__ . '->' . __FUNCTION__ . ' DEBUT');
		if (session_status() == PHP_SESSION_NONE && isset($_COOKIE['membership_id'])) {
			$this->getToken();
            session_start();
		}
		elseif (session_status() == PHP_SESSION_ACTIVE && !isset($_COOKIE['membership_id'])) {
			session_destroy();
		}
	}

	public function getCurrentUser($memberId)
	{
		$this->logger->info(__CLASS__ . '->' . __FUNCTION__ . ' DEBUT');
		$client = HttpClient::create();
		$response = $client->request('GET', $_ENV['URL_GET_USER'], [
			'headers' => [
				'X-Api-Key' => $_ENV['API_KEY'],
				'Authorization' => 'Bearer ' . $_COOKIE['access_token']
            ],
		]);
		return json_decode($response->getContent());
	}
}