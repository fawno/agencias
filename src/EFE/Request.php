<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use GuzzleHttp\Client;
	use GuzzleHttp\ClientInterface;
	use GuzzleHttp\Exception\GuzzleException;
	use Fawno\Agencias\EFE\Exception\AuthenticationException;
	use Fawno\Agencias\EFE\Exception\ForbiddenException;
	use Fawno\Agencias\EFE\Exception\HttpException;
	use Fawno\Agencias\EFE\Exception\NotFoundException;
	use Fawno\Agencias\EFE\Exception\TransportException;
	use Psr\Http\Message\ResponseInterface;

	class Request {
		public const BASE_URL = 'https://apinews.efeservicios.com';
		public const METHOD = 'GET';
		public const ENDPOINT = '/account/token';

		protected static function _call (string $query, ?string $token, ?ClientInterface $client = null) : ResponseInterface {
			$client ??= new Client();

			$headers = ['Accept' => 'application/json'];

			if (null !== $token) {
				$headers['Authorization'] = 'Bearer ' . $token;
			}

			try {
				$response = $client->request(static::METHOD, static::BASE_URL . static::ENDPOINT . $query, [
					'headers' => $headers,
					'http_errors' => false,
				]);
			} catch (GuzzleException $exception) {
				throw new TransportException('No se ha podido completar la petición a EFE.', 0, $exception);
			}

			$statusCode = $response->getStatusCode();
			if (($statusCode < 200) or ($statusCode >= 300)) {
				$body = $response->getBody()->getContents();
				throw match ($statusCode) {
					401 => new AuthenticationException($body),
					403 => new ForbiddenException($body),
					404 => new NotFoundException($body),
					default => new HttpException($statusCode, $body),
				};
			}

			return $response;
		}
	}
