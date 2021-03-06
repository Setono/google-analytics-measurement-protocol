<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Client;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\Client\Response\DebugResponse;
use Setono\GoogleAnalyticsMeasurementProtocol\DTO\Event\PurchaseEventData;
use Setono\GoogleAnalyticsMeasurementProtocol\Hit\HitBuilder;
use Setono\GoogleAnalyticsMeasurementProtocol\Hit\HitBuilderInterface;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Client\Client
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Client\Response\DebugResponse
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Client\Response\HitParsingResult
 */
final class ClientTest extends TestCase
{
    /**
     * @test
     */
    public function it_sends_hit(): void
    {
        $client = new Client();
        $client->setDebug(true);

        /** @var DebugResponse $response */
        $response = $client->sendHit('v=1&tid=UA-23901888-1&cid=555&t=pageview&dp=/home');

        self::assertInstanceOf(DebugResponse::class, $response);
        self::assertTrue($response->wasValid());
        self::assertSame(200, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_sends_purchase_event(): void
    {
        $client = new Client();
        $client->setDebug(true);

        $hitBuilder = new HitBuilder(HitBuilderInterface::HIT_TYPE_PAGEVIEW);
        $hitBuilder->setClientId('123');
        $hitBuilder->setDocumentPath('/');

        $purchaseEvent = new PurchaseEventData('order-678', 'example.com', 489.96, 'USD', 5.45, 9.87);
        $purchaseEvent->applyTo($hitBuilder);

        /** @var DebugResponse $response */
        $response = $client->sendHit($hitBuilder->getHit('UA-123414-5')->getPayload());

        self::assertTrue($response->wasValid(), implode("\n", $response->getErrors()));
    }

    /**
     * @test
     */
    public function it_uses_custom_http_client(): void
    {
        $httpClient = new class() implements \Psr\Http\Client\ClientInterface {
            public bool $used = false;

            public function sendRequest(RequestInterface $request): ResponseInterface
            {
                $this->used = true;

                return new Response();
            }
        };

        $client = new Client($httpClient);

        $client->sendHit('v=1&tid=UA-23901888-1&cid=555');
        self::assertTrue($httpClient->used);
    }

    /**
     * @test
     */
    public function it_uses_custom_request_factory(): void
    {
        $requestFactory = new class(new Psr17Factory()) implements RequestFactoryInterface {
            public bool $used = false;

            private RequestFactoryInterface $requestFactory;

            public function __construct(RequestFactoryInterface $requestFactory)
            {
                $this->requestFactory = $requestFactory;
            }

            public function createRequest(string $method, $uri): RequestInterface
            {
                $this->used = true;

                return $this->requestFactory->createRequest($method, $uri);
            }
        };

        $client = new Client(null, $requestFactory);

        $client->sendHit('v=1&tid=UA-23901888-1&cid=555');
        self::assertTrue($requestFactory->used);
    }

    /**
     * @test
     */
    public function it_uses_custom_stream_factory(): void
    {
        $streamFactory = new class(new Psr17Factory()) implements StreamFactoryInterface {
            public bool $used = false;

            private StreamFactoryInterface $streamFactory;

            public function __construct(StreamFactoryInterface $streamFactory)
            {
                $this->streamFactory = $streamFactory;
            }

            public function createStream(string $content = ''): StreamInterface
            {
                $this->used = true;

                return $this->streamFactory->createStream($content);
            }

            public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
            {
                $this->used = true;

                return $this->streamFactory->createStreamFromFile($filename, $mode);
            }

            public function createStreamFromResource($resource): StreamInterface
            {
                $this->used = true;

                return $this->streamFactory->createStreamFromResource($resource);
            }
        };

        $client = new Client(null, null, $streamFactory);

        $client->sendHit('v=1&tid=UA-23901888-1&cid=555');
        self::assertTrue($streamFactory->used);
    }
}
