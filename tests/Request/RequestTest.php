<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request;

use PHPUnit\Framework\TestCase;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Body;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Request\Request
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Request\HasWithers
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

    /**
     * This test will test the HasWithers trait
     *
     * @test
     */
    public function it_is_immutable(): void
    {
        $body = Body::create('CLIENT_ID');
        $request = Request::create('API_SECRET', 'G-12341234', $body);

        $newBody = Body::create('NEW_CLIENT_ID');
        $newRequest = $request->withApiSecret('NEW_API_SECRET')
            ->withMeasurementId('G-56785678')
            ->withBody($newBody)
        ;

        // test that the original $request has the same values
        self::assertSame('API_SECRET', $request->getApiSecret());
        self::assertSame('G-12341234', $request->getMeasurementId());
        self::assertSame($body, $request->getBody());

        // test that the new object is NOT the same as the old object and test the new values
        self::assertNotSame($request, $newRequest);
        self::assertSame('NEW_API_SECRET', $newRequest->getApiSecret());
        self::assertSame('G-56785678', $newRequest->getMeasurementId());
        self::assertSame($newBody, $newRequest->getBody());
    }
}
