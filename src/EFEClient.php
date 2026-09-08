<?php
	declare(strict_types=1);

	namespace Fawno\Agencias;

	use DateTimeImmutable;
	use DateTimeZone;
	use Fawno\Agencias\EFE\ContentByIdRequest;
	use Fawno\Agencias\EFE\ContentByProductIdRequest;
	use Fawno\Agencias\EFE\Format;
	use Fawno\Agencias\EFE\ContentInFormat;
	use Fawno\Agencias\EFE\ContentResponse;
	use Fawno\Agencias\EFE\FormatRequest;
	use Fawno\Agencias\EFE\JWT\JWT;
	use Fawno\Agencias\EFE\LangCode;
	use Fawno\Agencias\EFE\ModelDataRequest;
	use Fawno\Agencias\EFE\ModelDataResponse;
	use Fawno\Agencias\EFE\ModelsRequest;
	use Fawno\Agencias\EFE\ModelsResponse;
	use Fawno\Agencias\EFE\ProductRequest;
	use Fawno\Agencias\EFE\ProductResponse;
	use Fawno\Agencias\EFE\Sort;
	use Fawno\Agencias\EFE\TokenRequest;

	class EFEClient {
		public const BASE_URL = 'https://apinews.efeservicios.com';
		private string $token;
		private DateTimeImmutable $expires;

		private function __construct (private readonly string $clientId, private readonly string $clientSecret) {
		}

		public static function create (string $clientId, string $clientSecret) : static {

			return new static($clientId, $clientSecret);
		}

		public function getProducts (LangCode $lang_code = LangCode::ES) : ProductResponse {
			return ProductRequest::call($this->getToken(), $lang_code);
		}

		public function getModels () : ModelsResponse {
			return ModelsRequest::call($this->getToken());
		}

		public function getModelData (
			string $model_to_query,
			?string $text_filter = null,
			?int $int_filter = null,
			LangCode $lang_code = LangCode::ES,
		) : ModelDataResponse {
			return ModelDataRequest::call(
				token: $this->getToken(),
				model_to_query: $model_to_query,
				text_filter: $text_filter,
				int_filter: $int_filter,
				lang_code: $lang_code,
			);
		}

		public function getItemsByProductId (
			int $product_id,
			Sort $sort = Sort::ASC,
			?DateTimeImmutable $date_from = null,
			?DateTimeImmutable $date_to = null,
			int $start_itemId = 0,
			int $page = 0,
			int $page_size = 10,
			LangCode $lang_code = LangCode::ES,
			FormatRequest $format = FormatRequest::JSON,
		) : ContentResponse|string {
			return ContentByProductIdRequest::call(
				token: $this->getToken(),
				product_id: $product_id,
				sort: $sort,
				date_from: $date_from,
				date_to: $date_to,
				start_itemId: $start_itemId,
				page: $page,
				page_size: $page_size,
				lang_code: $lang_code,
				format: $format,
			);
		}

		public function getItemById (
			int $item_id,
			LangCode $lang_code = LangCode::ES,
			FormatRequest $format = FormatRequest::JSON,
		) : ContentResponse|string {
			return ContentByIdRequest::call(
				token: $this->getToken(),
				item_id: $item_id,
				lang_code: $lang_code,
				format: $format,
			);
		}

		public function getItemsInFormat (
			Format $format_id,
			Sort $sort = Sort::ASC,
			?DateTimeImmutable $date_from = null,
			?DateTimeImmutable $date_to = null,
			int $start_itemId = 0,
			int $page = 0,
			int $page_size = 10,
			LangCode $lang_code = LangCode::ES,
			FormatRequest $format = FormatRequest::JSON,
		) : ContentResponse|string {
			return ContentInFormat::call(
				token: $this->getToken(),
				format_id: $format_id,
				sort: $sort,
				date_from: $date_from,
				date_to: $date_to,
				start_itemId: $start_itemId,
				page: $page,
				page_size: $page_size,
				lang_code: $lang_code,
				format: $format,
			);
		}

		private function getToken () : string {
			if (isset($this->token) and ($this->expires > (new DateTimeImmutable('+300seconds')))) {
				return $this->token;
			}

			$this->token = TokenRequest::call($this->clientId, $this->clientSecret, $this->token ?? null);
			$this->expires = JWT::decode($this->token)->exp->setTimezone(new DateTimeZone(date_default_timezone_get()));

			return $this->token;
		}
	}
