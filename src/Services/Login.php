<?php
namespace App\Services;

use Symfony\Component\HttpClient\HttpClient;

class Login 
{
	const URL = "https://www.bungie.net/Platform/App/OAuth/token/";
	const AUTH = 'Basic ';
	const CLIENT_ID = "31249";
	const SECRET_TOKEN = "9CT6JX8cLr9qwSgXe3EWE1Ea9hlG1PPvSKj0Xdv6XhE";

    public function getToken($code)
    {
		$client = HttpClient::create();
		$response = $client->request('POST', self::URL, [
			'headers' => [
				'Content-Type' => 'application/x-www-form-urlencoded',
				'Authorization' => self::AUTH . base64_encode(self::CLIENT_ID . ":" . self::SECRET_TOKEN)
			],
			'body' => [
				'grant_type' => 'authorization_code',
				'code' => $code
			],
		]);

        return json_decode($response->getContent());
	}
	
	public function setCookies()
	{
		
	}
}