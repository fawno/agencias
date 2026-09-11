<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\Tests;

	use DateTimeImmutable;
	use Fawno\Agencias\EFE\DateTimeEFE;
	use PHPUnit\Framework\TestCase;

	final class DateTimeEFETest extends TestCase {
		protected const EFE_DATETIME_STRINGS = [
			'NOW'              => 'NOW',
			'NOW-24HOURS'      => 'NOW-24HOURS',
			'NOW-24HOUR'       => 'NOW-24HOUR',
			'NOW-7DAYS'        => 'NOW-7DAYS',
			'NOW-7DAY'         => 'NOW-7DAY',
			'-7day'            => 'NOW-7DAY',
			null               => 'NOW',
			''                 => 'NOW',
			'20260908T220000Z' => '20260908T220000',
			'20260908T220000'  => '20260908T220000',
		];

		public function testEFEStringFormats () : void {
			foreach (static::EFE_DATETIME_STRINGS as $input => $expected) {
				$actual = DateTimeEFE::createFromString($input)->formatEFE();
				$this->assertEquals($expected, $actual);
			}

			foreach (static::EFE_DATETIME_STRINGS as $input => $expected) {
				$actual = (new DateTimeEFE($input))->formatEFE();
				$this->assertEquals($expected, $actual);
			}
		}

		public function testCreateFromString () : void {
			$expected = (new DateTimeImmutable('20260909T000000'))->format('Ymd\THise');

			$actual = DateTimeEFE::createFromString('20260908T220000Z')->format('Ymd\THise');
			$this->assertEquals($expected, $actual);

			$actual = DateTimeEFE::createFromString('20260908T220000')->format('Ymd\THise');
			$this->assertEquals($expected, $actual);


			$expected = (new DateTimeEFE('20260908T220000Z'))->format('Ymd\THise');
			$actual = DateTimeEFE::createFromString('20260908T220000Z')->format('Ymd\THise');
			$this->assertEquals($expected, $actual);

			$expected = (new DateTimeEFE('20260908T220000'))->format('Ymd\THise');
			$actual = DateTimeEFE::createFromString('20260908T220000')->format('Ymd\THise');
			$this->assertEquals($expected, $actual);
		}
	}
