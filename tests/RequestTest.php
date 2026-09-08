<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\Tests;

	use Fawno\Agencias\EFE\Exception\AuthenticationException;
	use Fawno\Agencias\EFE\Exception\ForbiddenException;
	use Fawno\Agencias\EFE\Exception\HttpException;
	use Fawno\Agencias\EFE\Exception\NotFoundException;
	use Fawno\Agencias\EFE\Exception\TransportException;
	use Fawno\Agencias\EFE\Request;
	use GuzzleHttp\Client;
	use GuzzleHttp\ClientInterface;
	use GuzzleHttp\Exception\ConnectException;
	use GuzzleHttp\Handler\MockHandler;
	use GuzzleHttp\HandlerStack;
	use GuzzleHttp\Psr7\Request as PsrRequest;
	use GuzzleHttp\Psr7\Response;
	use PHPUnit\Framework\Attributes\DataProvider;
	use PHPUnit\Framework\TestCase;

	final class RequestTest extends TestCase {
		public static function httpErrors () : iterable {
			yield 'authentication' => [401, AuthenticationException::class];
			yield 'forbidden product' => [403, ForbiddenException::class];
			yield 'not found' => [404, NotFoundException::class];
			yield 'generic server error' => [500, HttpException::class];
		}

		#[DataProvider('httpErrors')]
		public function testTranslatesHttpErrors (int $statusCode, string $exceptionClass) : void {
			$client = $this->clientWith(new Response($statusCode, [], 'synthetic response'));

			try {
				RequestProbe::call($client);
				self::fail('An HTTP exception was expected.');
			} catch (HttpException $exception) {
				self::assertInstanceOf($exceptionClass, $exception);
				self::assertSame($statusCode, $exception->statusCode);
				self::assertSame('synthetic response', $exception->responseBody);
			}
		}

		public function testReturnsSuccessfulResponse () : void {
			$response = RequestProbe::call($this->clientWith(new Response(200, [], '{}')));

			self::assertSame(200, $response->getStatusCode());
			self::assertSame('{}', (string) $response->getBody());
		}

		public function testTranslatesTransportErrors () : void {
			$error = new ConnectException('private low-level message', new PsrRequest('GET', 'https://example.test'));

			$this->expectException(TransportException::class);
			$this->expectExceptionMessage('No se ha podido completar la petición a EFE.');

			RequestProbe::call($this->clientWith($error));
		}

		private function clientWith (Response|ConnectException $result) : ClientInterface {
			return new Client(['handler' => HandlerStack::create(new MockHandler([$result]))]);
		}
	}

	final class RequestProbe extends Request {
		public const BASE_URL = 'https://example.test';
		public const ENDPOINT = '/resource';

		public static function call (ClientInterface $client) : \Psr\Http\Message\ResponseInterface {
			return parent::_call('', null, $client);
		}
	}
