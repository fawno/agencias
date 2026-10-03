<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Collection;

	use Fawno\Agencias\EFE\ContentObject;
	use SimpleXMLElement;
	use stdClass;

	/**
	 * @extends EFECollection<int|string, ContentObject>
	 */
	class CollectionObjects extends EFECollection {
		public static function fromXML (SimpleXMLElement $xml) : static {
			$items = [];

			foreach ($xml->Object ?? [] as $item) {
				$items[] = ContentObject::fromXML($item);
			}

			return new static($items);
		}

		public static function fromObjects (stdClass ...$objects) : static {
			$items = [];

			foreach ($objects as $object) {
				$items[] = ContentObject::fromObject($object);
			}

			return new static($items);
		}
	}
