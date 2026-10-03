<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Collection;

	use Fawno\Agencias\EFE\Item;
	use SimpleXMLElement;
	use stdClass;

	/**
	 * @extends EFECollection<int|string, Item>
	 */
	class CollectionItems extends EFECollection {
		final public static function fromItems (Item ...$items) : static {
			return new static($items);
		}

		public static function fromXML (SimpleXMLElement $xml) : static {
			$items = [];

			foreach ($xml->Item ?? [] as $item) {
				$items[] = Item::fromXML($item);
			}

			return new static($items);
		}

		public static function fromObjects (stdClass ...$objects) : static {
			$items = [];

			foreach ($objects as $object) {
				$items[] = Item::fromObject($object);
			}

			return new static($items);
		}
	}
