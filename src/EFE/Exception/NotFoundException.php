<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Exception;

	class NotFoundException extends HttpException {
		public function __construct (string $responseBody = '') {
			parent::__construct(404, $responseBody, 'La búsqueda no ha devuelto resultados o algún parámetro no es válido.');
		}
	}
