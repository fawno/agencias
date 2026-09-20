<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class DataItems {
		private function __construct (
			public readonly Envelope $envelope,
			public readonly CollectionItems $items,
		) {}

		public static function fromObject (stdClass $object) : static {
			return new static(
				Envelope::fromObject($object->envelope ?? $object->Envelope),
				CollectionItems::fromObjects(...$object->items ?? (is_array($object->Items->Item ?? []) ? ($object->Items->Item ?? []) : [$object->Items->Item])),
			);
		}
	}
