<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

final class SearchEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $event = new SearchEvent();
        $event->parameters->searchTerm = 't-shirts';

        self::assertSame(['name' => 'search', 'params' => ['search_term' => 't-shirts']], $event->toArray());
    }
}
