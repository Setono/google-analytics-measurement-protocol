<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Client\Response;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Client\Response\DebugResponse
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Client\Response\HitParsingResult
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
        self::assertSame([], $debugResponse->getHitParsingResults());
    }

    /**
     * @test
     */
    public function it_is_invalid_if_one_hit_parsing_result_is_invalid(): void
    {
        $response = new Response(200, '{"hitParsingResult":[{"valid":true,"hit":"thehit","parserMessage":[]},{"valid":false,"hit":"thehit2","parserMessage":[{"description":"invalid"}]}]}');
        $debugResponse = new DebugResponse($response);

        self::assertFalse($debugResponse->wasValid());
    }
}
