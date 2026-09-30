<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	class ModelDataRequest extends Request {
		public const METHOD = 'GET';
		public const ENDPOINT = '/models/get_model_data';

		public static function call (
			string $token,
			string $model_to_query,
			?string $text_filter = null,
			?int $int_filter = null,
			LangCode $lang_code = LangCode::ES,
		) : ModelDataResponse  {
			$query = '?' . http_build_query([
				'model_to_query' => $model_to_query,
				'text_filter' => $text_filter,
				'int_filter' => $int_filter,
				'lang_code' => $lang_code,
			]);

			$response = parent::_call($query, $token);
			return ModelDataResponse::fromJson($response->getBody()->getContents());
		}
	}
