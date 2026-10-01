<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Fawno\Agencias\EFE\Collection\CollectionItems;
	use Fawno\Agencias\EFE\Exception\EFEException;
	use stdClass;

	class DataItems {
		final private function __construct (
			public readonly Envelope $envelope,
			public readonly CollectionItems $items,
		) {}

		public static function fromObject (stdClass $object) : static {
			$envelope = $object->envelope ?? null;
			$items = $object->items ?? null;

			if (!($envelope instanceof stdClass) or !is_array($items)) {
				throw new EFEException('Missing core structural properties in stdClass payload.');
			}

			return new static(
				Envelope::fromObject($envelope),
				CollectionItems::fromObjects(...$items),
			);
		}
	}
