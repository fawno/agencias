<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class ImageProperties {
		final private function __construct (
			public readonly ImageOrientation $orientation,
			public readonly ImageColor $color,
			public readonly ImagePlane $plane,
		) {
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				ImageOrientation::fromValue($object->orientation->code ?? ($object->Orientation->Code ?? null)),
				ImageColor::fromValue($object->color->code ?? ($object->Color->Code ?? null)),
				ImagePlane::fromValue($object->plane->code ?? ($object->Plane->Code ?? null)),
			);
		}
	}
