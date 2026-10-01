<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Response;

	use Fawno\Agencias\EFE\DataModels;
	use stdClass;

	class ModelsResponse {
		final private function __construct (
			public readonly DataModels $data,
		) {
		}

		public static function fromJson (string $json) : static {
			return static::fromObject(json_decode($json));
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				DataModels::fromObject($object->data),
			);
		}
	}
