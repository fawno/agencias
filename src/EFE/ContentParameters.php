<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class ContentParameters {
		private function __construct (
			public readonly ?int $item_id,
			public readonly ?string $q,
			public readonly ?int $product_id,
			public readonly ?Format $format_Id,
			public readonly ?Sort $sort,
			public readonly ?int $page,
			public readonly ?int $page_size,
			public readonly LangCode $lang_code,
			public readonly DateTimeEFE|string|null $date_from,
			public readonly DateTimeEFE|string|null $date_to,
			public readonly ?int $start_itemId,
			public readonly ?int $versionefe,
			public readonly ?int $client_id,
		) {}

		public static function fromObject (stdClass $object) : static {
			if (is_object($versionefe = $object->versionefe ?? null)) {
				$versionefe = empty($versionefe = (array) $versionefe) ? null : current($versionefe);
			}

			if (is_object($client_id = $object->client_id ?? null)) {
				$client_id = empty($client_id = (array) $client_id) ? null : current($client_id);
			}

			return new static(
				$object->item_id ?? null,
				$object->q ?? null,
				($object->product_id ?? null) ? (int) $object->product_id : null,
				Format::tryFrom((int) ($object->format_Id ?? ($object->Format_Id ?? 0))),
				Sort::tryFrom((string) ($object->sort ?? null)),
				(int) $object->page,
				(int) $object->page_size,
				LangCode::from((string) $object->lang_code),
				($object->date_from ?? null) ? DateTimeEFE::createFromString((string) $object->date_from ?? null) : null,
				($object->date_to ?? null) ? DateTimeEFE::createFromString((string) $object->date_to ?? null) : null,
				($object->start_itemId ?? null) ? (int) $object->start_itemId : null,
				$versionefe,
				$client_id,
			);
		}
	}
