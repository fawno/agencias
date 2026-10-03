<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Request;

	use Fawno\Agencias\EFE\Response\ContentResponse;
	use Fawno\Agencias\EFE\FormatRequest;
	use Fawno\Agencias\EFE\LangCode;

	class ContentByIdRequest extends Request {
		public const METHOD = 'GET';
		public const ENDPOINT = '/content/item_ById';

		public static function call (
			string $token,
			int $item_id,
			LangCode $lang_code = LangCode::ES,
			FormatRequest $format = FormatRequest::JSON,
		) : ContentResponse|string {
			$query = '?' . http_build_query([
				'item_id' => $item_id,
				'lang_code' => $lang_code,
				'format' => $format->value,
			]);

			$response = parent::_call($query, $token);
			return match($format) {
				FormatRequest::JSON => ContentResponse::fromJson($response->getBody()->getContents()),
				FormatRequest::XML => ContentResponse::fromXML($response->getBody()->getContents()),
				default => $response->getBody()->getContents(),
			};
		}
	}
