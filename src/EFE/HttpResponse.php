<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Fawno\Agencias\EFE\Exception\EFEException;
	use stdClass;

	class HttpResponse {
		final private function __construct (
			public readonly int $code,
			public readonly string $status,
		) {}

		public static function fromObject (stdClass $object) : static {
			$code = $object->code ?? null;
			$status = $object->status ?? null;

			if (!is_numeric($code) or !is_string($status)) {
				throw new EFEException('Missing core structural properties in stdClass payload.');
			}

			return new static((int) $code, (string) $status);
		}
	}
