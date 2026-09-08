<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class ModelParameters {
		private function __construct (
			public readonly string $lang_code,
			public readonly string $model_to_query,
			public readonly string $text_filter,
			public readonly int $int_filter,
		) {}

		public static function fromObject (stdClass $object) : static {
			return new static(
				$object->lang_code,
				$object->model_to_query,
				$object->text_filter,
				$object->int_filter,
			);
		}
	}
