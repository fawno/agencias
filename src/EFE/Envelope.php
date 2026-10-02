<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Fawno\Agencias\EFE\Exception\EFEException;
	use SimpleXMLElement;
	use stdClass;

	class Envelope {
		final private function __construct (
			public readonly int $itemsCount,
			public readonly int $totalFound,
		) {}

		public static function fromXML (SimpleXMLElement $xml) : static {
			$itemsCount = (null !== ($xml->ItemsCount ?? null)) ? (string) $xml->ItemsCount : null;
			$totalFound = (null !== ($xml->TotalFound ?? null)) ? (string) $xml->TotalFound : null;

			if (!is_numeric($itemsCount) or !is_numeric($totalFound)) {
				throw new EFEException('Missing or invalid core structural properties in XML payload.');
			}

			return new static(
				(int) $itemsCount,
				(int) $totalFound,
			);
		}

		public static function fromObject (stdClass $object) : static {
			$itemsCount = $object->itemsCount ?? null;
			$totalFound = $object->totalFound ?? null;

			if (!is_numeric($itemsCount) or !is_numeric($totalFound)) {
				throw new EFEException('Missing core structural properties in stdClass payload.');
			}

			return new static(
				(int) $itemsCount,
				(int) $totalFound,
			);
		}
	}
