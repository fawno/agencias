<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class HttpResponse {
		private function __construct (
			public readonly int $code,
			public readonly string $status,
		) {}

		public static function fromObject (stdClass $object) : static {
			return new static((int) ($object->code ?? $object->Code), (string) ($object->status ?? $object->Status));
		}
	}
