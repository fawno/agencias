<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Collection;

	use Fawno\Agencias\EFE\Product;
	use stdClass;

	/**
	 * @extends EFECollection<int|string, Product>
	 */
	class CollectionProducts extends EFECollection {
		public static function fromObjects (stdClass ...$objects) : CollectionProducts {
			$items = [];

			foreach ($objects as $object) {
				$items[] = Product::fromObject($object);
			}

			return new CollectionProducts($items);
		}
	}
