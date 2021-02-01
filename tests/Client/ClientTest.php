<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Client;

use PHPUnit\Framework\TestCase;
use Setono\GoogleAnalyticsMeasurementProtocol\Client\Response\DebugResponse;

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
        self::assertSame(200, $response->getStatusCode());
    }
}
