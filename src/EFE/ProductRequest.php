<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	class ProductRequest extends Request {
		public const METHOD = 'GET';
		public const ENDPOINT = '/account/products';

		public static function call (string $token, LangCode $lang_code = LangCode::ES) : ProductResponse  {
			$query = '?' . http_build_query([
				'lang_code' => $lang_code,
			]);

			$response = parent::_call($query, $token);
			return ProductResponse::fromJson($response->getBody()->getContents());
		}
	}
