<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class ImageProperties {
		private function __construct (
			public readonly Orientation $orientation,
			public readonly Color $color,
			public readonly Plane $plane,
		) {
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				Orientation::fromValue($object->orientation->code),
				Color::from($object->color->code),
				Plane::fromObject($object->plane),
			);
		}
	}
