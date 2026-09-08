<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Exception;

	class ForbiddenException extends HttpException {
		public function __construct (string $responseBody = '') {
			parent::__construct(403, $responseBody, 'El cliente no tiene acceso al recurso o producto solicitado.');
		}
	}
