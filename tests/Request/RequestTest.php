<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request;

use PHPUnit\Framework\TestCase;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Body;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Request\Request
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Request\HasSetters
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
     * This test will test the HasSetters trait
     *
     * @test
     */
    public function it_is_immutable(): void
    {
        $request = Request::create('API_SECRET', 'G-12341234', Body::create('CLIENT_ID'));

        $newRequest = $request->setApiSecret('NEW_API_SECRET')
            ->setMeasurementId('G-56785678')
        ;

        // test that the original $request has the same values
        self::assertSame('NEW_API_SECRET', $request->getApiSecret());
        self::assertSame('G-56785678', $request->getMeasurementId());

        // test that the new object IS the same as the old object
        self::assertSame($request, $newRequest);
    }
}
