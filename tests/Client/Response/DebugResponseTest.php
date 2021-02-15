<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Client\Response;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Client\Response\DebugResponse
 */
final class DebugResponseTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_correct_values(): void
    {
        $response = new Response(200, '{"hitParsingResult":[]}');
        $debugResponse = new DebugResponse($response);

        self::assertSame(200, $debugResponse->getStatusCode());
        self::assertSame('{"hitParsingResult":[]}', $debugResponse->getBody());
        self::assertSame([], $debugResponse->getParsingResult());
    }
}
