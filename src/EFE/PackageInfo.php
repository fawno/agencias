<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Fawno\Agencias\EFE\Collection\CollectionGuideComplements;
	use Fawno\Agencias\EFE\Collection\CollectionKeyWords;
	use Fawno\Agencias\EFE\DateTimeEFE;
	use stdClass;

	class PackageInfo {
		final private function __construct (
			public readonly int $id,
			public readonly int $version,
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
			public readonly MetaData $metaData,
			public readonly ObjectsCount $objectsCount,
		) {
		}

		public static function fromObject (stdClass $object) : static {
			return new static(
				(int) ($object->id ?? $object->Id),
				(int) ($object->version ?? $object->Version),
				Format::from($object->format->id ?? ((int) $object->Format->Id)),
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
				MetaData::fromObject($object->metaData ?? $object->MetaData),
				ObjectsCount::fromObject($object->objectsCount ?? $object->ObjectsCount),
			);
		}
	}
