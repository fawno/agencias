<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use Cake\Collection\Collection;

	/**
	 * @extends Collection<int|string, string>
	 */
	class CollectionKeyWords extends Collection {
		public static function fromStrings (string ...$strings) : CollectionKeyWords {
			return new CollectionKeyWords($strings);
		}
	}
