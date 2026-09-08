<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use GuzzleHttp\Client;
	use Psr\Http\Message\ResponseInterface;

	class Request {
		public const BASE_URL = 'https://apinews.efeservicios.com';
		public const METHOD = 'GET';
		public const ENDPOINT = '/account/token';

		protected static function _call (string $query, ?string $token) : ResponseInterface {
			$client = new Client();

			$headers = ['Accept' => 'application/json'];

			if (null !== $token) {
				$headers['Authorization'] = 'Bearer ' . $token;
			}

			$response = $client->request(static::METHOD, static::BASE_URL . static::ENDPOINT . $query, [
				'headers' => $headers,
			]);

			return $response;
		}
	}
