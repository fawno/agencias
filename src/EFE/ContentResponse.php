<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

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

		public static function fromXML (string $xml) : static {
			$json = json_decode(json_encode(simplexml_load_string($xml)));
			return static::fromObject($json);
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				httpResponse::fromObject($object->httpResponse ?? $object->HttpResponse),
				ContentParameters::fromObject($object->parameters ?? $object->Parameters),
				DataItems::fromObject($object->data ?? $object->Data),
			);
		}
	}
