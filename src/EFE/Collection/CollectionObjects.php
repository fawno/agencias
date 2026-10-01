<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Collection;

	use Fawno\Agencias\EFE\ContentObject;
	use stdClass;

	/**
	 * @extends EFECollection<int|string, ContentObject>
	 */
	class CollectionObjects extends EFECollection {
		public static function fromObjects (stdClass ...$objects) : CollectionObjects {
			$items = [];

			foreach ($objects as $object) {
				$items[] = ContentObject::fromObject($object);
			}

			return new CollectionObjects($items);
		}
	}
