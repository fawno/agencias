<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\Tests;

	use Fawno\Agencias\EFE\Exception\EFEException;
	use Fawno\Agencias\EFE\Response\ContentResponse;
	use PHPUnit\Framework\TestCase;

	final class ContentResponseTest extends TestCase {
		public function testCreatesTypedResponseFromSyntheticJson () : void {
			$json = file_get_contents(__DIR__ . '/Fixtures/content.json');
			self::assertIsString($json);

			$response = ContentResponse::fromJson($json);
			$item = $response->data->items->first();

			self::assertSame(200, $response->httpResponse->code);
			self::assertSame(1, $response->data->envelope->itemsCount);
			self::assertSame('Titular completamente ficticio', $item->packageInfo->title);
			self::assertSame('Texto ficticio para pruebas.', $item->objects->first()->text);
		}

		public function testCreatesTypedResponseFromSyntheticXml () : void {
			$xml = file_get_contents(__DIR__ . '/Fixtures/content.xml');
			self::assertIsString($xml);

			$response = ContentResponse::fromXML($xml);
			$item = $response->data->items->first();

			self::assertSame(200, $response->httpResponse->code);
			self::assertSame(1, $response->data->envelope->itemsCount);
			self::assertSame('Titular completamente ficticio', $item->packageInfo->title);
			self::assertSame('Texto ficticio para pruebas.', $item->objects->first()->text);
			self::assertSame('T', $item->packageInfo->guideComplements->first()->id);
			self::assertSame('Pruebas', $item->packageInfo->metaData->classification->description);
		}

		public function testThrowsExceptionOnInvalidJson () : void {
			$this->expectException(EFEException::class);
			$this->expectExceptionMessage('Invalid JSON payload provided.');

			ContentResponse::fromJson('{invalid json');
		}

		public function testThrowsExceptionOnInvalidXml () : void {
			$this->expectException(EFEException::class);
			$this->expectExceptionMessage('Invalid XML payload provided.');

			ContentResponse::fromXML('<invalid xml');
		}

		public function testThrowsExceptionOnMissingXmlCoreProperties () : void {
			$this->expectException(EFEException::class);
			$this->expectExceptionMessage('Missing core structural properties in XML payload.');

			ContentResponse::fromXML('<ContentResponse><HttpResponse><Code>200</Code><Status>OK</Status></HttpResponse></ContentResponse>');
		}

		public function testThrowsExceptionOnMissingJsonCoreProperties () : void {
			$this->expectException(EFEException::class);
			$this->expectExceptionMessage('Missing core structural properties in stdClass payload.');

			ContentResponse::fromJson('{"httpResponse": {"code": 200, "status": "OK"}}');
		}
	}
