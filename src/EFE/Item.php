<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class Item {
		final private function __construct (
			public readonly PackageInfo $packageInfo,
			public readonly CollectionObjects $objects,
		) {
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				PackageInfo::fromObject($object->packageInfo),
				CollectionObjects::fromObjects(...$object->objects),
			);
		}
	}
