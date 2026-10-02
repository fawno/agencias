<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Fawno\Agencias\EFE\Exception\EFEException;
	use SimpleXMLElement;
	use stdClass;

	class HttpResponse {
		final private function __construct (
			public readonly int $code,
			public readonly string $status,
		) {}

		public static function fromXML (SimpleXMLElement $xml) : static {
			$code = (null !== ($xml->Code ?? null)) ? (string) $xml->Code : null;
			$status = (null !== ($xml->Status ?? null)) ? (string) $xml->Status : null;

			if (!is_numeric($code) or !is_string($status)) {
				throw new EFEException('Missing or invalid core structural properties in XML payload.');
			}

			return new static((int) $code, (string) $status);
		}

		public static function fromObject (stdClass $object) : static {
			$code = $object->code ?? null;
			$status = $object->status ?? null;

			if (!is_numeric($code) or !is_string($status)) {
				throw new EFEException('Missing core structural properties in stdClass payload.');
			}

			return new static((int) $code, (string) $status);
		}
	}
