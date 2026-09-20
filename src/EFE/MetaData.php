<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class MetaData {
		private function __construct (
			public readonly ?Classification $classification,
			public readonly string $langCode,
			public readonly Relevance $relevance,
			public readonly CollectionIptc $iptcList,
			public readonly GeoProperties $geoProperties,
			public readonly string $source,
			public readonly string $credit,
			public readonly string $editor,
			public readonly CollectionAuthors $authors,
		) {
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				($object->classification ?? ($object->Classification ?? null)) ? Classification::fromObject($object->classification ?? $object->Classification) : null,
				$object->langCode ?? $object->LangCode,
				Relevance::from((int) ($object->relevance->id ?? $object->Relevance->Id)),
				CollectionIptc::fromObjects(...($object->iptcList ?? (is_array($object->IptcList->Iptc) ? $object->IptcList->Iptc : [$object->IptcList->Iptc]))),
				GeoProperties::fromObject($object->geoProperties ?? $object->GeoProperties),
				$object->source ?? (is_string($object->Source) ? $object->Source : ''),
				$object->credit ?? (is_string($object->Credit) ? $object->Credit : ''),
				$object->editor ?? (is_string($object->Editor) ? $object->Editor : ''),
				CollectionAuthors::fromStrings(...($object->authors ?? (is_array($object->Authors->Author ?? []) ? ($object->Authors->Author ?? []) : [$object->Authors->Author]))),
			);
		}
	}
