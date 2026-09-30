<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class Product {
		final private function __construct (
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
				Format::from($object->format->id),
				Classification::fromObject($object->classification),
			);
		}
	}
