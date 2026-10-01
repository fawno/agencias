<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class ObjectsCount {
		final private function __construct (
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
				(int) ($object->total ?? $object->Total),
				(int) ($object->texts ?? $object->Texts),
				(int) ($object->photos ?? $object->Photos),
				(int) ($object->infographics ?? $object->Infographics),
				(int) ($object->audios ?? $object->Audios),
				(int) ($object->videos ?? $object->Videos),
				(int) ($object->files ?? $object->Files),
			);
		}
	}
