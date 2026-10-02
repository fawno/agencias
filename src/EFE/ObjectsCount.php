<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use SimpleXMLElement;
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

		public static function fromXML (SimpleXMLElement $xml) : static {
			return new static(
				(int) $xml->Total,
				(int) $xml->Texts,
				(int) $xml->Photos,
				(int) $xml->Infographics,
				(int) $xml->Audios,
				(int) $xml->Videos,
				(int) $xml->Files,
			);
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
