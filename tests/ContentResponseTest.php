<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\Tests;

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
	}
