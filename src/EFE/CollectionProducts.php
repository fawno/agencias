<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Cake\Collection\Collection;
	use stdClass;

	/**
	 * @extends Collection<int|string, Product>
	 */
	class CollectionProducts extends Collection {
		public static function fromObjects (stdClass ...$objects) : CollectionProducts {
			$items = [];

			foreach ($objects as $object) {
				$items[] = Product::fromObject($object);
			}

			return new CollectionProducts($items);
		}
	}
