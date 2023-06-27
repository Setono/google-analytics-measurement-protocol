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
        $request = self::getRequest($body);

        self::assertSame('API_SECRET', $request->getApiSecret());
        self::assertSame('G-12341234', $request->getMeasurementId());
        self::assertSame($body, $request->getBody());

        $payload = $request->getPayload();
        self::assertArrayHasKey('client_id', $payload);
        self::assertArrayHasKey('timestamp_micros', $payload);
    }

    /**
     * @test
     */
    public function it_is_mutable(): void
    {
        $newBody = Body::create('NEW_CLIENT_ID');
        $request = self::getRequest();
        $request->setApiSecret('NEW_API_SECRET')
            ->setMeasurementId('G-987651')
            ->setBody($newBody)
        ;

        self::assertSame('NEW_API_SECRET', $request->getApiSecret());
        self::assertSame('G-987651', $request->getMeasurementId());
        self::assertSame($newBody, $request->getBody());
    }

    private static function getRequest(Body $body = null): Request
    {
        $body ??= Body::create('CLIENT_ID');

        return new Request('API_SECRET', 'G-12341234', $body);
    }
}
