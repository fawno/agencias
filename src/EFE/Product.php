<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class Product {
		private function __construct (
			public readonly int $id,
			public readonly string $name,
			public readonly Format $format,
			public readonly Classification $classification,
		) {
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				$object->id,
				$object->name,
				Format::fromObject($object->format),
				Classification::fromObject($object->classification),
			);
		}
	}
