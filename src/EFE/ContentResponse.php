<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class ContentResponse {
		final private function __construct (
			public readonly HttpResponse $httpResponse,
			public readonly ContentParameters $parameters,
			public readonly DataItems $data,
		) {
		}

		public static function fromJson (string $json) : ContentResponse {
			return static::fromObject(json_decode($json));
		}

		public static function fromObject (stdClass $object) : ContentResponse {
			return new static(
				HttpResponse::fromObject($object->httpResponse),
				ContentParameters::fromObject($object->parameters),
				DataItems::fromObject($object->data),
			);
		}
	}
