<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Fawno\Agencias\EFE\Collection\CollectionProducts;
	use stdClass;

	class DataProducts {
		final private function __construct (
			public readonly Envelope $envelope,
			public readonly CollectionProducts $products,
		) {}

		public static function fromObject (stdClass $object) : static {
			return new static(
				Envelope::fromObject($object->envelope),
				CollectionProducts::fromObjects(...$object->products),
			);
		}
	}
