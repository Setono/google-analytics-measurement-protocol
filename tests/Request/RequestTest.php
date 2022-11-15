<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request;

use PHPUnit\Framework\TestCase;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Body;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Request\Request
 */
final class RequestTest extends TestCase
{
    /**
     * @test
     */
    public function it_initializes(): void
    {
        $body = Body::create('CLIENT_ID');
        $request = Request::create('API_SECRET', 'G-12341234', $body);

        self::assertSame('API_SECRET', $request->getApiSecret());
        self::assertSame('G-12341234', $request->getMeasurementId());
        self::assertSame($body, $request->getBody());
    }
}
