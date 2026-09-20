<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class File {
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
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				$object->formatIdentifier ?? $object->FormatIdentifier,
				$object->fileName ?? $object->FileName,
				$object->url ?? $object->Url,
				$object->mimeType ?? $object->MimeType,
				(int) ($object->width ?? $object->Width),
				(int) ($object->height ?? $object->Height),
				(int) ($object->bpp ?? $object->Bpp),
				(float) ($object->bitrateKbps ?? $object->BitrateKbps),
				(int) ($object->sizeBytes ?? $object->SizeBytes),
			);
		}
	}
