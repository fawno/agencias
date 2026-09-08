<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class DataCode {
		private function __construct (
			public readonly ?string $code,
			public readonly ?string $description) {
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				$object->code ?? null,
				$object->description ?? null,
			);
		}
	}
