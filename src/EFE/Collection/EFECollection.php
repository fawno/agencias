<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Collection;

	use Cake\Collection\Collection;

	/**
	 * @template TKey
	 * @template TValue
	 * @extends Collection<TKey, TValue>
	 */
	class EFECollection extends Collection {
    final protected function __construct (iterable $items) {
			parent::__construct($items);
    }
	}
