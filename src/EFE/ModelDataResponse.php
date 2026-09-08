<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class ModelDataResponse {
		private function __construct (
			public readonly httpResponse $httpResponse,
			public readonly ModelParameters $parameters,
			public readonly DataModelItems $data,
		) {
		}

		public static function fromJson (string $json) : static {
			return static::fromObject(json_decode($json));
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				httpResponse::fromObject($object->httpResponse),
				ModelParameters::fromObject($object->parameters),
				DataModelItems::fromObject($object->data),
			);
		}
	}
