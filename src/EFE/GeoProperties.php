<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use SimpleXMLElement;
	use stdClass;

	class GeoProperties {
		final private function __construct (
			public readonly ?string $area,
			public readonly ?string $countryCode,
			public readonly ?string $region,
			public readonly ?string $city,
		) {
		}

		public static function fromXML (SimpleXMLElement $xml) : static {
			return new static(
				(string) ($xml->Area ?? null) ?: null,
				(string) ($xml->CountryCode ?? null) ?: null,
				(string) ($xml->Region ?? null) ?: null,
				(string) ($xml->City ?? null) ?: null,
			);
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				$object->area ?? null,
				$object->countryCode ?? null,
				$object->region ?? null,
				$object->city ?? null,
			);
		}
	}
