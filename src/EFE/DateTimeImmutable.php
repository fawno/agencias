<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use DateTimeZone;

	class DateTimeImmutable extends \DateTimeImmutable {
		public static function createFromString (?string $datetime, ?DateTimeZone $timezone = null) : static|string|null {
			if (!preg_match('~^\d{8}T\d{6}~', (string) $datetime)) {
				return $datetime;
			}

			$datetime = preg_replace('~^(\d{8}T\d{6})$~', '$1Z', $datetime);
			$timezone ??= new DateTimeZone(date_default_timezone_get());

			return (new static($datetime))->setTimezone($timezone);
		}
	}
