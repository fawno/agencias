<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Collection;

	use Fawno\Agencias\EFE\File;
	use SimpleXMLElement;
	use stdClass;

	/**
	 * @extends EFECollection<int|string, File>
	 */
	class CollectionFiles extends EFECollection {
		public static function fromXML (SimpleXMLElement $xml) : static {
			$items = [];

			foreach ($xml->File ?? [] as $object) {
				$items[] = File::fromXML($object);
			}

			return new static($items);
		}

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
