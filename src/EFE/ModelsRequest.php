<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	class ModelsRequest extends Request {
		public const METHOD = 'GET';
		public const ENDPOINT = '/models';

		public static function call (string $token) : ModelsResponse  {
			$response = parent::_call('', $token);
			return ModelsResponse::fromJson($response->getBody()->getContents());
		}
	}
