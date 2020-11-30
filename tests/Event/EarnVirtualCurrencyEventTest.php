<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

final class EarnVirtualCurrencyEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $event = new EarnVirtualCurrencyEvent();
        $event->parameters->virtualCurrencyName = 'Gems';
        $event->parameters->value = 5;

        self::assertSame(['name' => 'earn_virtual_currency', 'params' => ['virtual_currency_name' => 'Gems', 'value' => 5]], $event->toArray());
    }
}
