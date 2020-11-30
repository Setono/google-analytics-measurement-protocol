<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

final class SpendVirtualCurrencyEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $event = new SpendVirtualCurrencyEvent();
        $event->parameters->itemName = 'Starter Boost';
        $event->parameters->virtualCurrencyName = 'Gems';
        $event->parameters->value = 5;

        self::assertSame([
            'name' => 'spend_virtual_currency',
            'params' => ['item_name' => 'Starter Boost', 'virtual_currency_name' => 'Gems', 'value' => 5],
        ], $event->toArray());
    }
}
