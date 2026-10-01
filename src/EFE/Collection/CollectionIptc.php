<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Collection;

	use Fawno\Agencias\EFE\Iptc;
	use stdClass;

	/**
	 * @extends EFECollection<int|string, Iptc>
	 */
	class CollectionIptc extends EFECollection {
		public static function fromObjects (stdClass ...$objects) : static {
			$items = [];

			foreach ($objects as $object) {
				$items[] = Iptc::fromObject($object);
			}

			return new static($items);
		}
	}
