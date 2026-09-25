<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	enum ImagePlane : string {
		case PLANO_AMERICANO = 'PA';
		case PLANO_BUSTO     = 'PB';
		case PLANO_GENERAL   = 'PG';
		case PLANO_MEDIO     = 'PM';
		case PRIMER_PLANO    = 'PP';
		case NO_ESPECIFICADO = 'NE';
		case DESCONOCIDO     = 'D';

		public function description () : string {
			return match ($this) {
				self::PLANO_AMERICANO => 'Plano Americano',
				self::PLANO_BUSTO     => 'Plano Busto',
				self::PLANO_GENERAL   => 'Plano General',
				self::PLANO_MEDIO     => 'Plano Medio',
				self::PRIMER_PLANO    => 'Primer Plano',
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
