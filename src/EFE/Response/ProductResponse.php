<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Response;

	use Fawno\Agencias\EFE\DataProducts;
	use Fawno\Agencias\EFE\HttpResponse;
	use Fawno\Agencias\EFE\ProductsParameters;
	use stdClass;

	class ProductResponse {
		final private function __construct (
			public readonly HttpResponse $httpResponse,
			public readonly ProductsParameters $parameters,
			public readonly DataProducts $data,
		) {
		}

		public static function fromJson (string $json) : static {
			return static::fromObject(json_decode($json));
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				HttpResponse::fromObject($object->httpResponse),
				ProductsParameters::fromObject($object->parameters),
				DataProducts::fromObject($object->data),
			);
		}
	}
