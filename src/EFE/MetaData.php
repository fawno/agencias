<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Fawno\Agencias\EFE\Collection\CollectionAuthors;
	use Fawno\Agencias\EFE\Collection\CollectionIptc;
	use SimpleXMLElement;
	use stdClass;

	class MetaData {
		final private function __construct (
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

		public static function fromXML (SimpleXMLElement $xml) : static {
			return new static(
				!empty($xml->Classification) ? Classification::fromXML($xml->Classification) : null,
				(string) $xml->LangCode,
				Relevance::from((int) $xml->Relevance->Id),
				CollectionIptc::fromXML($xml->IptcList),
				GeoProperties::fromXML($xml->GeoProperties),
				(string) $xml->Source,
				(string) $xml->Credit,
				(string) $xml->Editor,
				CollectionAuthors::fromXML($xml->Authors),
			);
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				!empty($object->classification) ? Classification::fromObject($object->classification) : null,
				$object->langCode,
				Relevance::from($object->relevance->id),
				CollectionIptc::fromObjects(...$object->iptcList),
				GeoProperties::fromObject($object->geoProperties),
				$object->source,
				$object->credit,
				$object->editor,
				CollectionAuthors::fromStrings(...$object->authors),
			);
		}
	}
