<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Cake\Collection\Collection;
	use stdClass;

	class CollectionKeyWords extends Collection {
		public static function fromStrings (string ...$strings) : static {
			return new static($strings);
		}
	}
