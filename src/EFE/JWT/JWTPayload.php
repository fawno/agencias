<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\JWT;

	class JWTPayload {
		final private function __construct (
			public readonly string $iss,
			public readonly string $aud,
			public readonly int $exp,
			public readonly int $nbf,
			public readonly string $client_id,
			public readonly string $client_IdClienteEFE,
			public readonly string $client_OAuth2ClientRole,
			public readonly string $client_OAuth2ClientRateRequest,
			public readonly string $client_OAuth2ClientCreatedOn,
			public readonly string $client_OAuth2ClientLastTimeStatusChangedOn,
			public readonly string $client_OAuth2ClientCommentsAndNotes,
			public readonly string $scope,
		) {
		}

		public static function fromBase64 (string $base64) : static {
			return new static(...json_decode(base64_decode($base64), true));
		}
	}
