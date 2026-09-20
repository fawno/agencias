<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class Iptc {
		private function __construct (
			public readonly string $code,
			public readonly string $descriptionlevel1,
			public readonly string $descriptionlevel2,
			public readonly string $descriptionlevel3,
		) {
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				$object->code ?? $object->Code,
				$object->descriptionlevel1 ?? (is_string($object->Descriptionlevel1) ? $object->Descriptionlevel1 : ''),
				$object->descriptionlevel2 ?? (is_string($object->Descriptionlevel2) ? $object->Descriptionlevel2 : ''),
				$object->descriptionlevel3 ?? (is_string($object->Descriptionlevel3) ? $object->Descriptionlevel3 : ''),
			);
		}
	}
