<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	enum Format : int {
	  case TEXTO      =  1;
	  case FOTO       =  2;
	  case INFOGRAFIA =  3;
	  case REPORTAJE  =  4;
	  case MULTIMEDIA =  5;
	  case AUDIO      =  6;
	  case VIDEO      =  7;
	  case DOCUMENTAL =  8;
	  case FICHERO    =  9;
	  case DIRECTOS   = 10;

		public function description () : string {
			return match ($this) {
				self::TEXTO      => 'Texto',
				self::FOTO       => 'Foto',
				self::INFOGRAFIA => 'Infografía',
				self::REPORTAJE  => 'Reportaje',
				self::MULTIMEDIA => 'Multimedia',
				self::AUDIO      => 'Audio',
				self::VIDEO      => 'Vídeo',
				self::DOCUMENTAL => 'Módulo documental',
				self::FICHERO    => 'Fichero',
				self::DIRECTOS   => 'Directos',
			};
		}
	}
