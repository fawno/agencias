<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Collection;

	use stdClass;

	/**
	 * @extends EFECollection<int|string, stdClass>
	 */
	class CollectionModelItems extends EFECollection {
		public static function fromObjects (stdClass ...$objects) : static {
			return new static($objects);
		}
	}
