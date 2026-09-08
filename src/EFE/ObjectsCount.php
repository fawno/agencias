<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class ObjectsCount {
		private function __construct (
			public readonly int $total,
			public readonly int $texts,
			public readonly int $photos,
			public readonly int $infographics,
			public readonly int $audios,
			public readonly int $videos,
			public readonly int $files,
		) {
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				$object->total,
				$object->texts,
				$object->photos,
				$object->infographics,
				$object->audios,
				$object->videos,
				$object->files,
			);
		}
	}
