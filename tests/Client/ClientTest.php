<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Client;

use Nyholm\Psr7\Request as PsrRequest;
use Nyholm\Psr7\Response;
use Nyholm\Psr7\Stream;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Client\ClientInterface as HttpClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Body;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\AddToCartEvent;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Request;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Client\Client
 */
final class ClientTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_sends_request(): void
    {
        $client = new Client();
        $httpClient = new MockHttpClient();
        $client->setHttpClient($httpClient);

        $request = Request::create(
            'YOUR_SECRET',
            'G-12341234',
            Body::create('CLIENT_ID')
                ->addEvent(
                    AddToCartEvent::create()
                        ->setCurrency('USD')
                        ->setValue(123.45)
                        ->addItem(Item::create()->setId('SKU1234')->setName('Blue t-shirt')),
                )->setTimestamp(1668509674013800),
        );

        $client->sendRequest($request);
        self::assertNotNull($httpClient->lastRequest);
        self::assertSame('POST', $httpClient->lastRequest->getMethod());
        self::assertSame(
            'https://www.google-analytics.com/mp/collect?measurement_id=G-12341234&api_secret=YOUR_SECRET',
            (string) $httpClient->lastRequest->getUri(),
        );
        self::assertSame(
            '{"client_id":"CLIENT_ID","timestamp_micros":1668509674013800,"events":[{"name":"add_to_cart","params":{"currency":"USD","items":[{"item_id":"SKU1234","item_name":"Blue t-shirt","quantity":1}],"value":123.45}}]}',
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
                ->addEvent(
                    AddToCartEvent::create()
                        ->setCurrency('USD')
                        ->setValue(123.45)
                        ->addItem(Item::create()->setId('SKU1234')->setName('Blue t-shirt')),
                ),
        );

        $client->sendRequest($request);

        self::assertNotNull($client->getLastResponse());
        self::assertSame($client->getLastResponse()->getStatusCode(), 204);
    }

    /**
     * @test
     */
    public function it_sends_live_debug_request(): void
    {
        $client = new Client();
        $client->setDebug();

        $request = Request::create(
            'YOUR_SECRET',
            'G-12341234',
            Body::create('CLIENT_ID')
                ->addEvent(
                    AddToCartEvent::create()
                        ->setCurrency('USD')
                        ->setValue(123.45)
                        ->addItem(Item::create()->setId('SKU1234')->setName('Blue t-shirt')),
                ),
        );

        $client->sendRequest($request);

        $lastResponse = $client->getLastResponse();

        self::assertNotNull($lastResponse);
        self::assertSame($lastResponse->getStatusCode(), 200);

        $validation = json_decode((string) $lastResponse->getBody(), true, 512, \JSON_THROW_ON_ERROR);

        self::assertIsArray($validation);
        self::assertArrayHasKey('validationMessages', $validation);
        self::assertIsArray($validation['validationMessages']);
    }

    /**
     * @test
     */
    public function it_sends_request_to_other_host(): void
    {
        $client = new Client();
        $client->setHost('www.example.com');

        $httpClient = new MockHttpClient();
        $client->setHttpClient($httpClient);

        $request = Request::create('YOUR_SECRET', 'G-12341234', Body::create('CLIENT_ID'));

        $client->sendRequest($request);
        self::assertNotNull($httpClient->lastRequest);
        self::assertSame(
            'https://www.example.com/mp/collect?measurement_id=G-12341234&api_secret=YOUR_SECRET',
            (string) $httpClient->lastRequest->getUri(),
        );
    }

    /**
     * @test
     */
    public function it_uses_custom_factories(): void
    {
        $requestFactory = $this->prophesize(RequestFactoryInterface::class);
        $requestFactory
            ->createRequest('POST', Argument::any())
            ->willReturn(new PsrRequest('POST', 'https://example.com'))
            ->shouldBeCalledOnce()
        ;

        $streamFactory = $this->prophesize(StreamFactoryInterface::class);
        $streamFactory
            ->createStream(Argument::any())
            ->willReturn(Stream::create(''))
            ->shouldBeCalledOnce()
        ;

        $client = new Client();
        $client->setRequestFactory($requestFactory->reveal());
        $client->setStreamFactory($streamFactory->reveal());

        $request = Request::create(
            'YOUR_SECRET',
            'G-12341234',
            Body::create('CLIENT_ID')
                ->addEvent(
                    AddToCartEvent::create()
                        ->setCurrency('USD')
                        ->setValue(123.45)
                        ->addItem(Item::create()->setId('SKU1234')->setName('Blue t-shirt')),
                ),
        );

        $client->sendRequest($request);
    }
}

final class MockHttpClient implements HttpClientInterface
{
    public ?RequestInterface $lastRequest = null;

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $this->lastRequest = $request;

        return new Response(204);
    }
}
