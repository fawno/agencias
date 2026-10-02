<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Collection;

	use Fawno\Agencias\EFE\Exception\EFEException;
	use Fawno\Agencias\EFE\GuideComplement;
	use SimpleXMLElement;
	use stdClass;

	/**
	 * @extends EFECollection<int|string, GuideComplement>
	 */
	class CollectionGuideComplements extends EFECollection {
		public static function fromXML (SimpleXMLElement $xml) : static {
			$items = [];

			foreach ($xml->GuideComplement ?? [] as $item) {
				$items[] = GuideComplement::fromXML($item);
			}

			return new static($items);
		}

		public static function fromObjects (stdClass ...$objects) : static {
			$items = [];

			foreach ($objects as $object) {
				$items[] = GuideComplement::fromObject($object);
			}

			return new static($items);
		}
	}
