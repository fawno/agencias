<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use SimpleXMLElement;
	use stdClass;

	class ImageProperties {
		final private function __construct (
			public readonly ImageOrientation $orientation,
			public readonly ImageColor $color,
			public readonly ImagePlane $plane,
		) {
		}

		public static function fromXML (SimpleXMLElement $xml) : static {
			return new static(
				ImageOrientation::fromValue((string) ($xml->Orientation->Code ?? null) ?: null),
				ImageColor::fromValue((string) ($xml->Color->Code ?? null) ?: null),
				ImagePlane::fromValue((string) ($xml->Plane->Code ?? null) ?: null),
			);
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				ImageOrientation::fromValue($object->orientation->code ?? null),
				ImageColor::fromValue($object->color->code ?? null),
				ImagePlane::fromValue($object->plane->code ?? null),
			);
		}
	}
