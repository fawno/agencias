<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Collection;

	use Fawno\Agencias\EFE\File;
	use stdClass;

	/**
	 * @extends EFECollection<int|string, File>
	 */
	class CollectionFiles extends EFECollection {
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
