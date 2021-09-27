<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\DTO\Event;

use PHPUnit\Framework\TestCase;
use Setono\GoogleAnalyticsMeasurementProtocol\DTO\DTOInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\DTO\DTOTestTrait;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\DTO\Event\BeginCheckoutEventData
 */
final class BeginCheckoutEventDataTest extends TestCase
{
    use DTOTestTrait;

    protected function getDTO(): DTOInterface
    {
        return new BeginCheckoutEventData();
    }

    protected function getExpectedData(): array
    {
        return [
            'v' => '1',
            't' => 'event',
            'cid' => 'client_id',
            'ec' => 'ecommerce',
            'ea' => 'begin_checkout',
            'pa' => 'checkout',
            'tid' => 'UA-1234-1',
        ];
    }
}
