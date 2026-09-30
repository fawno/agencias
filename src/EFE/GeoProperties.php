<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class GeoProperties {
		final private function __construct (
			public readonly ?string $area,
			public readonly ?string $countryCode,
			public readonly ?string $region,
			public readonly ?string $city,
		) {
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
