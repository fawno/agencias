<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	enum Orientation : string {
		case HORIZONTAL = 'H';
		case VERTICAL   = 'V';

		public function description () : string {
			return match ($this) {
				self::HORIZONTAL => 'Horizontal',
				self::VERTICAL   => 'Vertical',
			};
		}
	}
