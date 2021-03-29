<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\DTO\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\DTO\ProductData;
use Setono\GoogleAnalyticsMeasurementProtocol\Hit\HitBuilder;
use Setono\GoogleAnalyticsMeasurementProtocol\TestCase;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\DTO\Event\PurchaseEventData
 */
final class PurchaseEventDataTest extends TestCase
{
    /**
     * @test
     */
    public function it_sets_initial_values(): void
    {
        $event = new PurchaseEventData('trans_1234', 'Example.com', 123.45, 'USD', 12.12, 1.34);

        self::assertSame('trans_1234', $event->transactionId);
        self::assertSame('Example.com', $event->affiliation);
        self::assertSame(123.45, $event->value);
        self::assertSame('USD', $event->currency);
        self::assertSame(12.12, $event->tax);
        self::assertSame(1.34, $event->shipping);
        self::assertSame([], $event->products);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function it_applies(): void
    {
        $event = new PurchaseEventData(
            'trans_1234',
            'Example.com',
            123.45,
            'USD',
            12.12,
            1.34,
            [ProductData::createAsProductType('product_123', 'Product 123')]
        );

        $hitBuilder = new HitBuilder();
        $hitBuilder->setClientId('client_id');

        $event->applyTo($hitBuilder);

        self::assertHit(<<<QUERY
            v=1
            &t=pageview
            &cid=client_id
            &pa=purchase
            &ti=trans_1234
            &ta=Example.com
            &tr=123.45
            &cu=USD
            &tt=12.12
            &ts=1.34
            &pr1id=product_123
            &pr1nm=Product%20123
            &tid=UA-1234-1
            QUERY, $hitBuilder->getHit('UA-1234-1'));
    }
}
