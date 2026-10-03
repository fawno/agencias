<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use SimpleXMLElement;
	use stdClass;

	class GuideComplement {
		final private function __construct (public readonly string $id, public readonly string $description) {
		}

		public static function fromXML (SimpleXMLElement $xml) : static {
			return new static((string) $xml->id, (string) $xml->Description);
		}

		public static function fromObject (stdClass $object) : static {
			return new static($object->id, $object->description);
		}
	}
