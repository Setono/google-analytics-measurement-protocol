<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Storage;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Storage\InMemoryStorage
 */
final class InMemoryStorageTest extends TestCase
{
    /**
     * @test
     */
    public function it_stores(): void
    {
        $storage = new InMemoryStorage();
        $storage->store('key', 'value');

        self::assertSame('value', $storage->restore('key'));
    }

    /**
     * @test
     */
    public function it_returns_null_if_key_is_absent(): void
    {
        $storage = new InMemoryStorage();
        self::assertNull($storage->restore('key'));
    }
}
