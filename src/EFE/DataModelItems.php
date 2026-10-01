<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Fawno\Agencias\EFE\Collection\CollectionModelItems;
	use stdClass;

	class DataModelItems {
		final private function __construct (
			public readonly Envelope $envelope,
			public readonly CollectionModelItems $items,
		) {}

		public static function fromObject (stdClass $object) : static {
			return new static(
				Envelope::fromObject($object->envelope),
				CollectionModelItems::fromObjects(...$object->modelItems),
			);
		}
	}
