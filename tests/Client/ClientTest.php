<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Client;

use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface as HttpClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Body;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\AddToCartEvent;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Request;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Client\Client
 */
final class ClientTest extends TestCase
{
    /**
     * @test
     */
    public function it_sends_request(): void
    {
        $client = new Client();
        $httpClient = new class() implements HttpClientInterface {
            public ?RequestInterface $lastRequest = null;

            public function sendRequest(RequestInterface $request): ResponseInterface
            {
                $this->lastRequest = $request;

                return new Response(204);
            }
        };
        $client->setHttpClient($httpClient);

        $request = Request::create(
            'YOUR_SECRET',
            'G-12341234',
            Body::create('CLIENT_ID')
                ->withEvent(
                    AddToCartEvent::create('USD', 123.45)
                        ->addItem(Item::create('SKU1234', 'Blue T-shirt')),
                ),
        );

        $client->sendRequest($request);
        self::assertNotNull($httpClient->lastRequest);
        self::assertSame('POST', $httpClient->lastRequest->getMethod());
        self::assertSame(
            'https://www.google-analytics.com/mp/collect?measurement_id=G-12341234&api_secret=YOUR_SECRET',
            (string) $httpClient->lastRequest->getUri(),
        );
        self::assertSame(
            '{"client_id":"CLIENT_ID","timestamp_micros":1668509674013800,"events":[{"name":"add_to_cart","params":{"currency":"USD","value":123.45,"items":[{"item_id":"SKU1234","item_name":"Blue T-shirt","quantity":1}]}}]}',
            (string) $httpClient->lastRequest->getBody(),
        );
    }

    /**
     * @test
     */
    public function it_sends_live_request(): void
    {
        $client = new Client();

        $request = Request::create(
            'YOUR_SECRET',
            'G-12341234',
            Body::create('CLIENT_ID')
                ->withEvent(
                    AddToCartEvent::create('USD', 123.45)
                        ->addItem(Item::create('SKU1234', 'Blue T-shirt')),
                ),
        );

        $client->sendRequest($request);

        self::assertSame($client->getLastResponse()->getStatusCode(), 204);
    }

    //
    ///**
    // * @test
    // */
    //public function it_uses_custom_request_factory(): void
    //{
    //    $requestFactory = new class(new Psr17Factory()) implements RequestFactoryInterface {
    //        public bool $used = false;
    //
    //        private RequestFactoryInterface $requestFactory;
    //
    //        public function __construct(RequestFactoryInterface $requestFactory)
    //        {
    //            $this->requestFactory = $requestFactory;
    //        }
    //
    //        public function createRequest(string $method, $uri): RequestInterface
    //        {
    //            $this->used = true;
    //
    //            return $this->requestFactory->createRequest($method, $uri);
    //        }
    //    };
    //
    //    $client = new Client(null, $requestFactory);
    //
    //    $client->sendHit('v=1&tid=UA-23901888-1&cid=555');
    //    self::assertTrue($requestFactory->used);
    //}
    //
    ///**
    // * @test
    // */
    //public function it_uses_custom_stream_factory(): void
    //{
    //    $streamFactory = new class(new Psr17Factory()) implements StreamFactoryInterface {
    //        public bool $used = false;
    //
    //        private StreamFactoryInterface $streamFactory;
    //
    //        public function __construct(StreamFactoryInterface $streamFactory)
    //        {
    //            $this->streamFactory = $streamFactory;
    //        }
    //
    //        public function createStream(string $content = ''): StreamInterface
    //        {
    //            $this->used = true;
    //
    //            return $this->streamFactory->createStream($content);
    //        }
    //
    //        public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
    //        {
    //            $this->used = true;
    //
    //            return $this->streamFactory->createStreamFromFile($filename, $mode);
    //        }
    //
    //        public function createStreamFromResource($resource): StreamInterface
    //        {
    //            $this->used = true;
    //
    //            return $this->streamFactory->createStreamFromResource($resource);
    //        }
    //    };
    //
    //    $client = new Client(null, null, $streamFactory);
    //
    //    $client->sendHit('v=1&tid=UA-23901888-1&cid=555');
    //    self::assertTrue($streamFactory->used);
    //}
}

/**
 * This will override the PHP function microtime for test purposes (as long as we don't use backslash when using microtime in our code
 */
function microtime(): float
{
    return 1668509674.0138;
}
