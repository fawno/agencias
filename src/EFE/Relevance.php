<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	enum Relevance : int {
		case RELEVANTE    = 1;
		case TOTAL        = 2;
		case MUYRELEVANTE = 3;
		case SELECCIÓN    = 4;
		case NORMAL       = 5;

		public function description () : string {
			return match ($this) {
				self::RELEVANTE    => 'Relevante',
				self::TOTAL        => 'Total',
				self::MUYRELEVANTE => 'Muy Relevante',
				self::SELECCIÓN    => 'Selección',
				self::NORMAL       => 'Normal',
			};
		}
	}
