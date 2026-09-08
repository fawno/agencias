<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class DataModels {
		private function __construct (
			public readonly Envelope $envelope,
			public readonly CollectionModels $models,
		) {}

		public static function fromObject (stdClass $object) : static {
			return new static(
				Envelope::fromObject($object->envelope),
				CollectionModels::fromStrings(...$object->modelItems),
			);
		}
	}
