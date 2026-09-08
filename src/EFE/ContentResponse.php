<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

use finfo;
use stdClass;

	class ContentResponse {
		private function __construct (
			public readonly httpResponse $httpResponse,
			public readonly ContentParameters $parameters,
			public readonly DataItems $data,
		) {
		}

		public static function fromJson (string $json) : static {
			return static::fromObject(json_decode($json));
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				httpResponse::fromObject($object->httpResponse),
				ContentParameters::fromObject($object->parameters),
				DataItems::fromObject($object->data),
			);
		}
	}
