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
				$object->id,
				$object->version,
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
				MetaData::fromObject($object->metaData),
				ObjectsCount::fromObject($object->objectsCount),
			);
		}
	}
