<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Collection;

	use SimpleXMLElement;

	/**
	 * @extends EFECollection<int|string, string>
	 */
	class CollectionKeyWords extends EFECollection {
		public static function fromXML (SimpleXMLElement $xml) : static {
			return new static((array) ($xml->string ?? []));
		}

		public static function fromStrings (string ...$strings) : static {
			return new static($strings);
		}
	}
