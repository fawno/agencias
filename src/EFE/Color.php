<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	enum Color : string {
		case COLOR = 'C';
		case BYN   = 'BN';

		public function description () : string {
			return match ($this) {
				self::COLOR => 'Color',
				self::BYN   => 'Blanco y Negro',
			};
		}
	}
