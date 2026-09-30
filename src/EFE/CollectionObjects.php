<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Cake\Collection\Collection;
	use stdClass;

	/**
	 * @extends Collection<int|string, ContentObject>
	 */
	class CollectionObjects extends Collection {
		public static function fromObjects (stdClass ...$objects) : CollectionObjects {
			$items = [];

			foreach ($objects as $object) {
				$items[] = ContentObject::fromObject($object);
			}

			return new CollectionObjects($items);
		}
	}
