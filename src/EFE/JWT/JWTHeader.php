<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\JWT;

	class JWTHeader {
		final private function __construct (public readonly string $typ, public readonly string $alg, public readonly string $x5t, public readonly string $kid) {
		}

		public static function fromBase64 (string $base64) : static {
			return new static(...json_decode(base64_decode($base64), true));
		}
	}
