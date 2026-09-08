<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Fawno\Agencias\EFE\DateTimeImmutable;
	use stdClass;

	class ContentParameters {
		private function __construct (
			public readonly ?int $item_id,
			public readonly ?string $q,
			public readonly ?int $product_id,
			public readonly Sort $sort,
			public readonly ?int $page,
			public readonly ?int $page_size,
			public readonly LangCode $lang_code,
			public readonly DateTimeImmutable|string|null $date_from,
			public readonly DateTimeImmutable|string|null $date_to,
			public readonly int $start_itemId,
			public readonly ?int $versionefe,
			public readonly ?int $client_id,
		) {}

		public static function fromObject (stdClass $object) : static {
			return new static(
				$object->item_id ?? null,
				$object->q ?? null,
				($object->product_id ?? null) ? (int) $object->product_id : null,
				Sort::from($object->sort),
				$object->page,
				$object->page_size,
				LangCode::from($object->lang_code),
				DateTimeImmutable::createFromString($object->date_from),
				DateTimeImmutable::createFromString($object->date_to),
				$object->start_itemId,
				$object->versionefe ?? null,
				$object->client_id ?? null,
			);
		}
	}
