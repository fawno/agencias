<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use SimpleXMLElement;
	use stdClass;

	class ContentParameters {
		final private function __construct (
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

		public static function fromXML (SimpleXMLElement $xml) : static {
			return new static(
				($xml->item_id ?? null) ? (int) $xml->item_id : null,
				($xml->q ?? null) ? (string) $xml->q : null,
				($xml->product_id ?? null) ? (int) $xml->product_id : null,
				Format::tryFrom((int) ($xml->Format_Id ?? 0)),
				Sort::tryFrom((string) ($xml->sort ?? null)),
				(int) $xml->page,
				(int) $xml->page_size,
				LangCode::from((string) $xml->lang_code),
				($xml->date_from ?? null) ? DateTimeEFE::createFromString((string) $xml->date_from) : null,
				($xml->date_to ?? null) ? DateTimeEFE::createFromString((string) $xml->date_to) : null,
				($xml->start_itemId ?? null) ? (int) $xml->start_itemId : null,
				!empty($xml->versionefe) ? (int) $xml->versionefe : null,
				!empty($xml->client_id) ? (int) $xml->client_id : null,
			);
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				$object->item_id ?? null,
				$object->q ?? null,
				($object->product_id ?? null) ? (int) $object->product_id : null,
				Format::tryFrom((int) ($object->format_Id ?? 0)),
				Sort::tryFrom((string) ($object->sort ?? null)),
				$object->page,
				$object->page_size,
				LangCode::from($object->lang_code),
				DateTimeEFE::createFromString($object->date_from ?? null),
				DateTimeEFE::createFromString($object->date_to ?? null),
				$object->start_itemId ?? null,
				$object->versionefe ?? null,
				$object->client_id ?? null,
			);
		}
	}
