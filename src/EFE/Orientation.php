<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	enum Orientation : string {
		case HORIZONTAL  = 'H';
		case VERTICAL    = 'V';
		case CUADRADA    = 'C';
		case DESCONOCIDO = 'D';

		public function description () : string {
			return match ($this) {
				self::HORIZONTAL  => 'Horizontal',
				self::VERTICAL    => 'Vertical',
				self::CUADRADA    => 'Cuadrada',
				self::DESCONOCIDO => 'Desconocido',
			};
		}

		public static function fromValue (string $value) : static {
			return static::tryFrom($value) ?? static::DESCONOCIDO;
		}
	}
