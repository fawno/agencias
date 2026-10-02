<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Fawno\Agencias\EFE\Collection\CollectionFiles;
	use Fawno\Agencias\EFE\Collection\CollectionGuideComplements;
	use Fawno\Agencias\EFE\Collection\CollectionKeyWords;
	use SimpleXMLElement;
	use stdClass;

	class ContentObject {
		final private function __construct (
			public readonly int $id,
			public readonly Format $format,
			public readonly DateTimeEFE $date,
			public readonly DateTimeEFE $firstCreated,
			public readonly string $guide,
			public readonly CollectionGuideComplements $guideComplements,
			public readonly string $title,
			public readonly string $subtitle,
			public readonly string $summary,
			public readonly string $text,
			public readonly int $wordsCount,
			public readonly CollectionKeyWords $keyWords,
			public readonly bool $tabSeparatedText,
			public readonly bool $richText,
			public readonly ?ImageProperties $imageProperties,
			public readonly ?AudioProperties $audioProperties,
			public readonly ?VideoProperties $videoProperties,
			public readonly MetaData $metaData,
			public readonly CollectionFiles $files,
		) {
		}

		public static function fromXML (SimpleXMLElement $xml) : static {
			return new static(
				(int) $xml->Id,
				Format::from((int) $xml->Format->Id),
				DateTimeEFE::createFromString((string) $xml->Date),
				DateTimeEFE::createFromString((string) $xml->FirstCreated),
				(string) $xml->Guide,
				CollectionGuideComplements::fromXML($xml->GuideComplements),
				(string) $xml->Title,
				(string) $xml->Subtitle,
				(string) $xml->Summary,
				(string) $xml->Text,
				(int) $xml->WordsCount,
				CollectionKeyWords::fromXML($xml->KeyWords),
				('true' === (string) $xml->TabSeparatedText),
				('true' === (string) $xml->RichText),
				!empty($xml->ImageProperties) ? ImageProperties::fromXML($xml->ImageProperties) : null,
				!empty($xml->AudioProperties) ? AudioProperties::fromXML($xml->AudioProperties) : null,
				!empty($xml->VideoProperties) ? VideoProperties::fromXML($xml->VideoProperties) : null,
				MetaData::fromXML($xml->MetaData),
				CollectionFiles::fromXML($xml->Files),
			);
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				$object->id,
				Format::from($object->format->id),
				DateTimeEFE::createFromString($object->date),
				DateTimeEFE::createFromString($object->firstCreated),
				$object->guide,
				CollectionGuideComplements::fromObjects(...$object->guideComplements),
				$object->title,
				$object->subtitle,
				$object->summary,
				$object->text,
				$object->wordsCount,
				CollectionKeyWords::fromStrings(...$object->keyWords),
				$object->tabSeparatedText,
				$object->richText,
				($object->imageProperties ?? null) ? ImageProperties::fromObject($object->imageProperties) : null,
				($object->audioProperties ?? null) ? AudioProperties::fromObject($object->audioProperties) : null,
				($object->videoProperties ?? null) ? VideoProperties::fromObject($object->videoProperties) : null,
				MetaData::fromObject($object->metaData),
				CollectionFiles::fromObjects(...($object->files ?? [])),
			);
		}
	}
