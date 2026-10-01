<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Request;

	use Fawno\Agencias\EFE\LangCode;

	class TokenRequest extends Request {
		public const METHOD = 'GET';
		public const ENDPOINT = '/account/token';

		public static function call (string $clientId, string $clientSecret, ?string $token = null, LangCode $lang_code = LangCode::ES) : string  {
			$query = '?' . http_build_query([
				'lang_code' => $lang_code,
				'clientId' => $clientId,
				'clientSecret' => $clientSecret,
			]);

			$response = parent::_call($query, $token);

			$token = $response->getBody()->getContents();
			$token = trim($token);
			$decoded = json_decode($token, true);

			return is_string($decoded) ? $decoded : $token;
		}
	}
