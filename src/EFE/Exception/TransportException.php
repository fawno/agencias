<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Exception;

	use Throwable;

	class TransportException extends EFEException {
		public function __construct (string $message, int $code = 0, ?Throwable $previous = null) {
			parent::__construct($message, $code, $previous);
		}
	}
