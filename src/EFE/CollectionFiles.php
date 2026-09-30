<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Cake\Collection\Collection;
	use stdClass;

	/**
	 * @extends Collection<int|string, File>
	 */
	class CollectionFiles extends Collection {
		public static function fromObjects (stdClass ...$objects) : static {
			$items = [];

			foreach ($objects as $object) {
				$items[] = File::fromObject($object);
			}

			return new static($items);
		}

		public function getHighestResolutionImage () : ?File {
			return $this->sortBy('area')->first();
		}
	}
