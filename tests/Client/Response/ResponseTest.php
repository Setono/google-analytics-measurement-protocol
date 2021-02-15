<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Client\Response;

use Nyholm\Psr7\Response as PsrResponse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Client\Response\Response
 */
final class ResponseTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_correct_values(): void
    {
        $response = new Response(200, 'body');

        self::assertSame(200, $response->getStatusCode());
        self::assertSame('body', $response->getBody());
    }

    /**
     * @test
     */
    public function it_creates_from_psr_response(): void
    {
        $response = Response::fromPsrResponse(new PsrResponse(200, [], 'body'));

        self::assertSame(200, $response->getStatusCode());
        self::assertSame('body', $response->getBody());
    }
}
