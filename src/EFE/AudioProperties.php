<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class AudioProperties {
		final private function __construct (
			public readonly string $type,
			public readonly int $duration,
			public readonly string $locution,
			public readonly string $timeline,
			public readonly string $transcription,
		) {
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				$object->type,
				$object->duration,
				$object->locution,
				$object->timeline,
				$object->transcription,
			);
		}
	}
