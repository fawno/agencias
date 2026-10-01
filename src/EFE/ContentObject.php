<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Fawno\Agencias\EFE\Collection\CollectionFiles;
	use Fawno\Agencias\EFE\Collection\CollectionGuideComplements;
	use Fawno\Agencias\EFE\Collection\CollectionKeyWords;
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


		public static function fromObject (stdClass $object) : static {
			return new static(
				(int) ($object->id ?? $object->Id),
				Format::from((int) ($object->format->id ?? $object->Format->Id)),
				DateTimeEFE::createFromString($object->date ?? $object->Date),
				DateTimeEFE::createFromString($object->firstCreated ?? $object->FirstCreated),
				$object->guide ?? (is_string($object->Guide) ? $object->Guide : ''),
				CollectionGuideComplements::fromObjects(...($object->guideComplements ?? (is_array($object->GuideComplements->GuideComplement ?? []) ? ($object->GuideComplements->GuideComplement ?? []) : [$object->GuideComplements->GuideComplement]))),
				$object->title ?? (is_string($object->Title) ? $object->Title : ''),
				$object->subtitle ?? (is_string($object->Subtitle) ? $object->Subtitle : ''),
				$object->summary ?? (is_string($object->Summary) ? $object->Summary : ''),
				$object->text ?? (is_string($object->Text) ? $object->Text : ''),
				(int) ($object->wordsCount ?? $object->WordsCount),
				CollectionKeyWords::fromStrings(...($object->keyWords ?? (is_array($object->KeyWords->string ?? []) ? ($object->KeyWords->string ?? []) : [$object->KeyWords->string]))),
				$object->tabSeparatedText ?? ('true' === $object->TabSeparatedText),
				$object->richText ?? ('true' === $object->RichText),
				($object->imageProperties ?? null) ? ImageProperties::fromObject($object->imageProperties ?? $object->ImageProperties) : null,
				($object->audioProperties ?? null) ? AudioProperties::fromObject($object->audioProperties ?? $object->AudioProperties) : null,
				($object->videoProperties ?? null) ? VideoProperties::fromObject($object->videoProperties ?? $object->VideoProperties) : null,
				MetaData::fromObject($object->metaData ?? $object->MetaData),
				CollectionFiles::fromObjects(...($object->files ?? ($object->Files->File ?? []))),
			);
		}
	}
