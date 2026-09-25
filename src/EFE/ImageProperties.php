<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class ImageProperties {
		private function __construct (
			public readonly ImageOrientation $orientation,
			public readonly ImageColor $color,
			public readonly ImagePlane $plane,
		) {
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				ImageOrientation::fromValue($object->orientation->code ?? null),
				ImageColor::fromValue($object->color->code ?? null),
				ImagePlane::fromValue($object->plane->code ?? null),
			);
		}
	}
