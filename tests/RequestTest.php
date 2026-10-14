<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\Tests;

	use Fawno\Agencias\EFEClient;
	use Fawno\Agencias\EFE\Exception\AuthenticationException;
	use Fawno\Agencias\EFE\Exception\ForbiddenException;
	use Fawno\Agencias\EFE\Exception\HttpException;
	use Fawno\Agencias\EFE\Exception\NotFoundException;
	use Fawno\Agencias\EFE\Exception\TransportException;
	use Fawno\Agencias\EFE\Request\Request;
	use GuzzleHttp\Client;
	use GuzzleHttp\ClientInterface;
	use GuzzleHttp\Exception\ConnectException;
	use GuzzleHttp\Handler\MockHandler;
	use GuzzleHttp\HandlerStack;
	use GuzzleHttp\Promise\FulfilledPromise;
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

		public function testDoesNotOverrideTimeoutsOfSuppliedClient () : void {
			$seen = [];
			$client = new Client([
				'connect_timeout' => 5,
				'timeout' => 7,
				'handler' => function (PsrRequest $request, array $options) use (&$seen) {
					$seen = $options;
					return new FulfilledPromise(new Response(200, [], '{}'));
				},
			]);

			RequestProbe::call($client);

			self::assertSame(5, $seen['connect_timeout']);
			self::assertSame(7, $seen['timeout']);
		}

		public function testDefaultClientUsesDefaultTimeouts () : void {
			self::assertSame([Request::CONNECT_TIMEOUT, Request::TIMEOUT], $this->timeoutsOf([]));
		}

		public function testDefaultClientTimeoutsCanBeOverridden () : void {
			self::assertSame([3, 300], $this->timeoutsOf(['connect_timeout' => 3, 'timeout' => 300]));
		}

		/**
		 * @param array<string, mixed> $config
		 * @return array{int, int}
		 */
		private function timeoutsOf (array $config) : array {
			$seen = [];
			$client = Request::createClient($config + ['handler' => function (PsrRequest $request, array $options) use (&$seen) {
				$seen = $options;
				return new FulfilledPromise(new Response(200, [], '{}'));
			}]);

			$client->request('GET', 'https://example.test/resource');

			return [$seen['connect_timeout'], $seen['timeout']];
		}
		public function testEFEClientUsesSuppliedClientForAllRequests () : void {
			$token = $this->fakeToken();
			$calls = [];
			$client = new Client(['handler' => function (PsrRequest $request, array $options) use (&$calls, $token) {
				$calls[] = $request->getUri()->getPath();
				$body = str_ends_with($request->getUri()->getPath(), '/account/token') ? json_encode($token) : 'not json';
				return new FulfilledPromise(new Response(200, [], $body));
			}]);

			try {
				EFEClient::create('id', 'secret', $client)->getProducts();
			} catch (\Throwable) {
				// Only the routing of the requests matters here, not parsing the synthetic body.
			}

			self::assertSame(['/account/token', '/account/products'], $calls);
		}

		private function fakeToken () : string {
			$header = ['typ' => 'JWT', 'alg' => 'RS256', 'x5t' => 'x', 'kid' => 'k'];
			$payload = [
				'iss' => 'i', 'aud' => 'a', 'exp' => time() + 3600, 'nbf' => time() - 60,
				'client_id' => 'c', 'client_IdClienteEFE' => '1', 'client_OAuth2ClientRole' => 'r',
				'client_OAuth2ClientRateRequest' => '1', 'client_OAuth2ClientCreatedOn' => 'd',
				'client_OAuth2ClientLastTimeStatusChangedOn' => 'd', 'client_OAuth2ClientCommentsAndNotes' => 'n', 'scope' => 's',
			];

			return base64_encode(json_encode($header)) . '.' . base64_encode(json_encode($payload)) . '.key';
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
