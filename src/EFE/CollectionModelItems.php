<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Cake\Collection\Collection;
	use stdClass;

	/**
	 * @extends Collection<int|string, stdClass>
	 */
	class CollectionModelItems extends Collection {
		public static function fromObjects (stdClass ...$objects) : static {
			return new static($objects);
		}
	}
