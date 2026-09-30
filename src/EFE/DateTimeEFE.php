<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	use DateTimeImmutable;
	use DateTimeZone;

	class DateTimeEFE extends DateTimeImmutable {
		final public function __construct (protected ?string $datetime = 'now', DateTimeZone|null $timezone = null) {
			$datetime = preg_replace('~^(\-\d+HOURS?|\-\d+DAYS?)$~i', 'NOW$1', ($datetime ?? 'now') ?: 'now');
			if (preg_match('~^(NOW|NOW\-\d+HOURS?|NOW\-\d+DAYS?)$~i', $datetime)) {
				$this->datetime = strtoupper($datetime);
			}

			if (preg_match('~^\d{8}T\d{6}Z?$~', $datetime)) {
				$timezone ??= new DateTimeZone(date_default_timezone_get());
				$datetime = new DateTimeImmutable($datetime, new DateTimeZone('UTC'));
				$datetime = $datetime->setTimezone($timezone)->format('Ymd\THis');
			}

			parent::__construct($datetime, $timezone);
		}

		public static function createFromString (?string $datetime, ?DateTimeZone $timezone = null) : static {
			return new static($datetime, $timezone);
		}

		public function formatEFE () : string {
			if (preg_match('~^(NOW|NOW\-\d+HOURS?|NOW\-\d+DAYS?)$~i', $this->datetime)) {
				return $this->datetime;
			}

			return $this->setTimezone(new DateTimeZone('UTC'))->format('Ymd\THis');
		}
	}
