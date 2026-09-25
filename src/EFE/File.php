<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class File {
		public readonly int $area;

		private function __construct (
			public readonly string $formatIdentifier,
			public readonly string $fileName,
			public readonly string $url,
			public readonly string $mimeType,
			public readonly int $width,
			public readonly int $height,
			public readonly int $bpp,
			public readonly float $bitrateKbps,
			public readonly int $sizeBytes,
		) {
			$this->area = $width * $height;
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				$object->formatIdentifier,
				$object->fileName,
				$object->url,
				$object->mimeType,
				$object->width,
				$object->height,
				$object->bpp,
				$object->bitrateKbps,
				$object->sizeBytes,
			);
		}
	}
