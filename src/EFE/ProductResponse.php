<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class ProductResponse {
		private function __construct (
			public readonly httpResponse $httpResponse,
			public readonly ProductsParameters $parameters,
			public readonly DataProducts $data,
		) {
		}

		public static function fromJson (string $json) : static {
			return static::fromObject(json_decode($json));
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				httpResponse::fromObject($object->httpResponse),
				ProductsParameters::fromObject($object->parameters),
				DataProducts::fromObject($object->data),
			);
		}
	}
