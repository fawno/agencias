<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class ProductsParameters {
		final private function __construct (
			public readonly ?string $lang_code = null,
			public readonly ?int $client_id = null,
			public readonly ?int $id_Servicio = null,
			public readonly ?int $idPaquete = null,
		) {}

		public static function fromObject (stdClass $object) : static {
			return new static(
				$object->lang_code,
				$object->client_id ?? null,
				$object->id_Servicio ?? null,
				$object->idPaquete ?? null,
			);
		}
	}
