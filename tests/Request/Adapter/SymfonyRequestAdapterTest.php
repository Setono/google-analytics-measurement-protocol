<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Adapter;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Request\Adapter\SymfonyRequestAdapter
 */
final class SymfonyRequestAdapterTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_expected_values(): void
    {
        $request = new class(['parameter' => 'value'], [], [], [], [], ['REMOTE_ADDR' => '127.0.0.1', 'HTTP_REFERER' => 'referrer', 'HTTP_USER_AGENT' => 'user agent']) extends Request {
            public function getUri(): string
            {
                return 'https://example.com';
            }
        };
        $adapter = new SymfonyRequestAdapter($request);

        self::assertSame('127.0.0.1', $adapter->getIp());
        self::assertSame('value', $adapter->getQueryValue('parameter'));
        self::assertSame('referrer', $adapter->getReferrer());
        self::assertSame('https://example.com', $adapter->getUrl());
        self::assertSame('user agent', $adapter->getUserAgent());
    }

    /**
     * @test
     */
    public function it_returns_sane_defaults(): void
    {
        $request = new class([], [], [], [], [], []) extends Request {
        };
        $adapter = new SymfonyRequestAdapter($request);

        self::assertSame('', $adapter->getIp());
        self::assertNull($adapter->getQueryValue('parameter'));
        self::assertNull($adapter->getReferrer());
        self::assertSame('', $adapter->getUserAgent());
    }
}
