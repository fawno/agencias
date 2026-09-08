<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Exception;

	class AuthenticationException extends HttpException {
		public function __construct (string $responseBody = '') {
			parent::__construct(401, $responseBody, 'La API de EFE ha rechazado la autenticación.');
		}
	}
