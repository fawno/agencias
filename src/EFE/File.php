<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Fawno\Agencias\EFE\Exception\EFEException;
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

		public function download (?string $filename = null, int $timeout = 20) : string|int {
			$parts = parse_url($this->url);
			if ((($parts['scheme'] ?? null) !== 'https') or (strcasecmp((string) ($parts['host'] ?? ''), 'apinews.efeservicios.com') !== 0)) {
				throw new EFEException(sprintf(
					'EFE returned an invalid file URL "%s".',
					$this->url,
				));
			}

			$file = false;
			if (($filename !== null) and (false === $file = @fopen($filename, 'wb'))) {
				$error = error_get_last();
				throw new EFEException(sprintf(
					'Could not open "%s" for writing%s.',
					$filename,
					isset($error['message']) ? ': ' . $error['message'] : '',
				));
			}

			if (false === $curl = curl_init($this->url)) {
				if (is_resource($file)) {
					fclose($file);
				}
				throw new EFEException('Could not initialize EFE file download via cURL.');
			}

			$options = [
				CURLOPT_HTTPGET => true,
				CURLOPT_NOBODY => false,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_AUTOREFERER => true,
				CURLOPT_NOPROGRESS => true,
				CURLOPT_CONNECTTIMEOUT => $timeout,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_PROTOCOLS_STR => 'https',
				CURLOPT_REDIR_PROTOCOLS_STR => 'https',
			];

			if (is_resource($file)) {
				$options[CURLOPT_RETURNTRANSFER] = false;
				$options[CURLOPT_FILE] = $file;
			}

			curl_setopt_array($curl, $options);

			try {
				$result = curl_exec($curl);
				$status = (int) curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
				$effectiveUrl = (string) curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);

				if ($result === false) {
					throw new EFEException(sprintf(
						'cURL error %d downloading EFE file from "%s": %s',
						curl_errno($curl),
						$effectiveUrl,
						curl_error($curl),
					));
				}

				if ($status < 200 || $status >= 300) {
					throw new EFEException(sprintf(
						'EFE file download failed with HTTP %d at "%s".',
						$status,
						$effectiveUrl,
					), $status);
				}

				if (!is_resource($file)) {
					$downloadedSize = strlen((string) $result);
					if ($this->sizeBytes !== $downloadedSize) {
						throw new EFEException(sprintf(
							'Downloaded content size mismatch. Expected %d bytes, got %d bytes.',
							$this->sizeBytes,
							$downloadedSize
						));
					}

					return (string) $result;
				}

				if (!fflush($file)) {
					throw new EFEException(sprintf('Could not flush written data buffer to disk for "%s".', $filename));
				}

				if (false === $size = (ftell($file) ?: false)) {
					clearstatcache(true, $filename);
					$size = file_exists($filename) ? filesize($filename) : false;
				}

				if (false === $size or $this->sizeBytes !== $size) {
					throw new EFEException(sprintf(
						'Saved file size mismatch for "%s". Expected %d bytes, got %s bytes.',
						$filename,
						$this->sizeBytes,
						(false === $size) ? 'unknown' : (string) $size
					));
				}

				return $size;
			} finally {
				if (is_resource($file)) {
					fclose($file);
				}
			}
		}
	}
