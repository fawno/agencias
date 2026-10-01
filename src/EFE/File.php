<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Fawno\Agencias\EFE\Exception\EFEException;
	use GuzzleHttp\Client;
	use GuzzleHttp\ClientInterface;
	use GuzzleHttp\Exception\GuzzleException;
	use Psr\Http\Message\ResponseInterface;
	use stdClass;

	class File {
		public readonly int $area;

		final private function __construct (
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

		public function download (?string $filename = null, int $timeout = 20, int $totalTimeout = 0, int $stallTimeout = 60, ?ClientInterface $client = null) : string|int {
			$parts = parse_url($this->url);
			if ((($parts['scheme'] ?? null) !== 'https') or (strcasecmp((string) ($parts['host'] ?? ''), 'apinews.efeservicios.com') !== 0)) {
				throw new EFEException(sprintf(
					'EFE returned an invalid file URL "%s".',
					$this->url,
				));
			}

			$file = null;
			if ($filename !== null) {
				if (false === $file = @fopen($filename, 'wb')) {
					$error = error_get_last();
					throw new EFEException(sprintf(
						'Could not open "%s" for writing%s.',
						$filename,
						isset($error['message']) ? ': ' . $error['message'] : '',
					));
				}
			}

			$client ??= new Client();
			$success = false;

			try {
				$options = [
					'http_errors' => false,
					'decode_content' => false,
					'connect_timeout' => $timeout,
					'timeout' => $totalTimeout,
					// Abort if the transfer drops below 1 byte/s for $stallTimeout seconds (0 disables).
					'curl' => ($stallTimeout > 0) ? [
						CURLOPT_LOW_SPEED_LIMIT => 1,
						CURLOPT_LOW_SPEED_TIME => $stallTimeout,
					] : [],
					'allow_redirects' => [
						'max' => 10,
						'protocols' => ['https'],
						'referer' => true,
					],
					// Abort on a bad status before any body is written to the sink.
					'on_headers' => function (ResponseInterface $response) use ($file) : void {
						$status = $response->getStatusCode();

						// Intermediate redirect: Guzzle follows it, the final response is validated below.
						if ($status >= 300 && $status < 400 && $response->hasHeader('Location')) {
							return;
						}

						if ($status < 200 || $status >= 300) {
							throw new EFEException(sprintf(
								'EFE file download failed with HTTP %d from "%s".',
								$status,
								$this->url,
							), $status);
						}

						// Final response: discard anything a redirect body may have written to the sink.
						if (is_resource($file) && (!ftruncate($file, 0) || !rewind($file))) {
							throw new EFEException('Could not reset the destination file before writing the download.');
						}
					},
				];

				if ($file !== null) {
					$options['sink'] = $file;
				}

				try {
					$response = $client->request('GET', $this->url, $options);
				} catch (GuzzleException $exception) {
					$previous = $exception->getPrevious();
					if ($previous instanceof EFEException) {
						throw $previous;
					}

					throw new EFEException(sprintf(
						'Error downloading EFE file from "%s": %s',
						$this->url,
						$exception->getMessage(),
					), 0, $exception);
				}

				if ($file === null) {
					$content = (string) $response->getBody();
					$downloadedSize = strlen($content);
					if ($this->sizeBytes !== $downloadedSize) {
						throw new EFEException(sprintf(
							'Downloaded content size mismatch. Expected %d bytes, got %d bytes.',
							$this->sizeBytes,
							$downloadedSize
						));
					}

					$success = true;
					return $content;
				}

				if (!fflush($file)) {
					throw new EFEException(sprintf('Could not flush written data buffer to disk for "%s".', $filename));
				}

				$stat = fstat($file);
				$size = ($stat === false) ? false : $stat['size'];

				if (false === $size or $this->sizeBytes !== $size) {
					throw new EFEException(sprintf(
						'Saved file size mismatch for "%s". Expected %d bytes, got %s bytes.',
						$filename,
						$this->sizeBytes,
						(false === $size) ? 'unknown' : (string) $size
					));
				}

				$success = true;
				return $size;
			} finally {
				if (is_resource($file)) {
					fclose($file);
				}

				// Never leave a partial or invalid file behind.
				if (!$success && $filename !== null) {
					@unlink($filename);
				}
			}
		}
	}
