<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\DTO\Event;

use PHPUnit\Framework\TestCase;
use Setono\GoogleAnalyticsMeasurementProtocol\DTO\DTOInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\DTO\DTOTestTrait;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\DTO\Event\AddPaymentInfoEventData
 */
final class AddPaymentInfoEventDataTest extends TestCase
{
    use DTOTestTrait;

    protected function getDTO(): DTOInterface
    {
        return new AddPaymentInfoEventData();
    }

    protected function getExpectedData(): array
    {
        return [
            'v' => '1',
            't' => 'event',
            'cid' => 'client_id',
            'ec' => 'ecommerce',
            'ea' => 'add_payment_info',
            'tid' => 'UA-1234-1',
        ];
    }
}
