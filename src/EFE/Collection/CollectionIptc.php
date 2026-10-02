<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Collection;

	use Fawno\Agencias\EFE\Iptc;
	use SimpleXMLElement;
	use stdClass;

	/**
	 * @extends EFECollection<int|string, Iptc>
	 */
	class CollectionIptc extends EFECollection {
		public static function fromXML (SimpleXMLElement $xml) : static {
			$items = [];

			foreach ($xml->Iptc ?? [] as $item) {
				$items[] = Iptc::fromXML($item);
			}

			return new static($items);
		}

		public static function fromObjects (stdClass ...$objects) : static {
			$items = [];

			foreach ($objects as $object) {
				$items[] = Iptc::fromObject($object);
			}

			return new static($items);
		}
	}
