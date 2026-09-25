<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	enum ImageColor : string {
		case COLOR           = 'C';
		case BYN             = 'BN';
		case NO_ESPECIFICADO = 'NE';
		case DESCONOCIDO     = 'D';

		public function description () : string {
			return match ($this) {
				self::COLOR           => 'Color',
				self::BYN             => 'Blanco y Negro',
				self::NO_ESPECIFICADO => 'No especificado',
				self::DESCONOCIDO     => 'Desconocido',
			};
		}

		public static function fromValue (?string $value) : static {
			if (null === $value or '' === trim($value)) {
				return static::NO_ESPECIFICADO;
			}

			$cleanValue = trim(strtoupper($value));

			return static::tryFrom($cleanValue) ?? static::DESCONOCIDO;
		}
	}
