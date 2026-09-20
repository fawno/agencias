<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class Envelope {
		private function __construct (
			public readonly int $itemsCount,
			public readonly int $totalFound,
		) {}

		public static function fromObject (stdClass $object) : static {
			return new static(
				$object->itemsCount ?? (($object->ItemsCount ?? null) ? (int) $object->ItemsCount : null),
				$object->totalFound ?? (($object->TotalFound ?? null) ? (int) $object->TotalFound : null),
			);
		}
	}
