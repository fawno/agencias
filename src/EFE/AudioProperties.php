<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use SimpleXMLElement;
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

		public static function fromXML (SimpleXMLElement $xml) : static {
			return new static(
				(string) $xml->Type,
				(int) $xml->Duration,
				(string) $xml->Locution,
				(string) $xml->Timeline,
				(string) $xml->Transcription,
			);
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
