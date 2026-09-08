<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Exception;

	class TooManyRequestsException extends HttpException {
		public function __construct (string $responseBody = '') {
			parent::__construct(429, $responseBody, 'You\'re requesting too many kittens! Slow down!.');
		}
	}
