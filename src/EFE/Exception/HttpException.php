<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Exception;

	class HttpException extends EFEException {
		public function __construct (
			public readonly int $statusCode,
			public readonly string $responseBody = '',
			string $message = '',
		) {
			parent::__construct($message ?: "La API de EFE ha respondido con HTTP $statusCode.", $statusCode);
		}
	}
