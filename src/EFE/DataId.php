<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Fawno\Agencias\EFE\Exception\EFEException;
	use SimpleXMLElement;
	use stdClass;

	class DataId {
		final private function __construct (public readonly int $id, public readonly string $description) {
		}

		public static function fromXML (SimpleXMLElement $xml) : static {
			$id = (null !== ($xml->Id ?? null)) ? (string) $xml->Id : null;
			$description = (null !== ($xml->Description ?? null)) ? (string) $xml->Description : null;

			if (!is_numeric($id) or !is_string($description)) {
				throw new EFEException('Missing or invalid core structural properties in XML payload.');
			}

			return new static((int) $id, $description);
		}

		public static function fromObject (stdClass $object) : static {
			$id = $object->id ?? null;
			$description = $object->description ?? null;

			if (!is_numeric($id) or !is_string($description)) {
				throw new EFEException('Missing core structural properties in stdClass payload.');
			}

			return new static($id, $description);
		}
	}
