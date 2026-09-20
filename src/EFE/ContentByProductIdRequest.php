<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	class ContentByProductIdRequest extends Request {
		public const METHOD = 'GET';
		public const ENDPOINT = '/content/items_ByProductId';

		public static function call (
			string $token,
			int $product_id,
			Sort $sort = Sort::ASC,
			?DateTimeEFE $date_from = null,
			?DateTimeEFE $date_to = null,
			int $start_itemId = 0,
			int $page = 0,
			int $page_size = 10,
			LangCode $lang_code = LangCode::ES,
			FormatRequest $format = FormatRequest::JSON,
		) : ContentResponse|string {
			$query = '?' . http_build_query([
				'product_id' => (string) $product_id,
				'sort' => $sort->value,
				'date_from' => $date_from?->formatEFE(),
				'date_to' => $date_to?->formatEFE(),
				'start_itemId' => $start_itemId,
				'page' => $page,
				'page_size' => ((0 < $page_size) and ($page_size <= 500)) ? $page_size : 10,
				'lang_code' => $lang_code,
				'format' => $format->value,
			]);

			$response = parent::_call($query, $token);
			return match($format) {
				FormatRequest::JSON => ContentResponse::fromJson($response->getBody()->getContents()),
				//FormatRequest::XML => ContentResponse::fromXML($response->getBody()->getContents()),
				default => $response->getBody()->getContents(),
			};
		}
	}
