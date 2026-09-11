<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\JWT;

	use Fawno\Agencias\EFE\DateTimeEFE;

	class JWT {
		public readonly DateTimeEFE $exp;
		public readonly DateTimeEFE $nbf;

		private function __construct (
			public readonly JWTHeader $header,
			public readonly JWTPayload $payload,
			protected readonly string $publicKey,
		) {
			$this->exp = (new DateTimeEFE('@' . $payload->exp));
			$this->nbf = (new DateTimeEFE('@' . $payload->nbf));
		}

		public static function decode (string $token) : static {
			list($jwt_header, $jwt_payload, $publicKey) = explode('.', $token);
			$jwt_header = JWTHeader::fromBase64($jwt_header);
			$jwt_payload = JWTPayload::fromBase64($jwt_payload);

			return new static($jwt_header, $jwt_payload, $publicKey);
		}
	}
