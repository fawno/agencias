<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class Iptc {
		final private function __construct (
			public readonly string $code,
			public readonly string $descriptionlevel1,
			public readonly string $descriptionlevel2,
			public readonly string $descriptionlevel3,
		) {
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				$object->code,
				$object->descriptionlevel1,
				$object->descriptionlevel2,
				$object->descriptionlevel3,
			);
		}
	}
