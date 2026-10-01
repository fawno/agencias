<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Collection;

	use Fawno\Agencias\EFE\GuideComplement;
	use stdClass;

	/**
	 * @extends EFECollection<int|string, GuideComplement>
	 */
	class CollectionGuideComplements extends EFECollection {
		public static function fromObjects (stdClass ...$objects) : static {
			$items = [];

			foreach ($objects as $object) {
				$items[] = GuideComplement::fromObject($object);
			}

			return new static($items);
		}
	}
