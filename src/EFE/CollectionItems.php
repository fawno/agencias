<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Cake\Collection\Collection;
	use stdClass;

	/**
	 * @extends Collection<int|string, Item>
	 */
	class CollectionItems extends Collection {
		public static function fromObjects (stdClass ...$objects) : static {
			$items = [];

			foreach ($objects as $object) {
				$items[] = Item::fromObject($object);
			}

			return new static($items);
		}
	}
