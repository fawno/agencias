<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Cake\Collection\Collection;
	use stdClass;

	/**
	 * @extends Collection<int|string, Iptc>
	 */
	class CollectionIptc extends Collection {
		public static function fromObjects (stdClass ...$objects) : CollectionIptc {
			$items = [];

			foreach ($objects as $object) {
				$items[] = Iptc::fromObject($object);
			}

			return new CollectionIptc($items);
		}
	}
