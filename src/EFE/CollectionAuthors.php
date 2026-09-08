<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Cake\Collection\Collection;
	use stdClass;

	class CollectionAuthors extends Collection {
		public static function fromStrings (string ...$strings) : static {
			return new static($strings);
		}
	}
