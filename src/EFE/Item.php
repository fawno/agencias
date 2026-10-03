<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Fawno\Agencias\EFE\Collection\CollectionObjects;
	use Fawno\Agencias\EFE\Exception\EFEException;
	use SimpleXMLElement;
	use stdClass;

	class Item {
		final private function __construct (
			public readonly PackageInfo $packageInfo,
			public readonly CollectionObjects $objects,
			public readonly ?SimpleXMLElement $xml = null,
		) {
		}

		public static function fromXML (SimpleXMLElement $xml) : static {
			$packageInfo = $xml->PackageInfo ?? null;
			$objects = $xml->Objects ?? null;

			if (!($packageInfo instanceof SimpleXMLElement) or !($objects instanceof SimpleXMLElement)) {
				throw new EFEException('Missing core structural properties in XML payload.');
			}

			return new static(
				PackageInfo::fromXML($packageInfo),
				CollectionObjects::fromXML($objects),
				$xml,
			);
		}

		public static function fromObject (stdClass $object) : static {
			$packageInfo = $object->packageInfo ?? null;
			$objects = $object->objects ?? null;

			if (!($packageInfo instanceof stdClass) or !is_array($objects)) {
				throw new EFEException('Missing core structural properties in stdClass payload.');
			}

			return new static(
				PackageInfo::fromObject($packageInfo),
				CollectionObjects::fromObjects(...$objects),
			);
		}
	}
