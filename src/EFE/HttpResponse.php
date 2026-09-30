<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class HttpResponse {
		final private function __construct (
			public readonly int $code,
			public readonly string $status,
		) {}

		public static function fromObject (stdClass $object) : static {
			return new static($object->code, $object->status);
		}
	}
