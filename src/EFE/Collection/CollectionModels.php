<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Collection;

	/**
	 * @extends EFECollection<int|string, string>
	 */
	class CollectionModels extends EFECollection {
		public static function fromStrings (string ...$strings) : static {
			return new static($strings);
		}
	}
