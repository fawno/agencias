<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Cake\Collection\Collection;
	use stdClass;

	/**
	 * @extends Collection<int|string, File>
	 */
	class CollectionFiles extends Collection {
		public static function fromObjects (stdClass ...$objects) : CollectionFiles {
			$items = [];

			foreach ($objects as $object) {
				$items[] = File::fromObject($object);
			}

			return new CollectionFiles($items);
		}

		public function getHighestResolutionImage () : ?File {
			return $this->sortBy('area')->first();
		}
	}
