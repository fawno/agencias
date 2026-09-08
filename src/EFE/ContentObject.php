<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use stdClass;

	class ContentObject {
		private function __construct (
			public readonly int $id,
			public readonly Format $format,
			public readonly string $date,
			public readonly string $firstCreated,
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
				$object->id,
				Format::fromObject($object->format),
				$object->date,
				$object->firstCreated,
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
