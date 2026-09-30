<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Cake\Collection\Collection;
	use stdClass;

	/**
	 * @extends Collection<int|string, GuideComplement>
	 */
	class CollectionGuideComplements extends Collection {
		public static function fromObjects (stdClass ...$objects) : CollectionGuideComplements {
			$items = [];

			foreach ($objects as $object) {
				$items[] = GuideComplement::fromObject($object);
			}

			return new CollectionGuideComplements($items);
		}
	}
