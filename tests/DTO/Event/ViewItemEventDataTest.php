<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\DTO\Event;

use PHPUnit\Framework\TestCase;
use Setono\GoogleAnalyticsMeasurementProtocol\DTO\DTOInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\DTO\DTOTestTrait;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\DTO\Event\ViewItemEventData
 */
final class ViewItemEventDataTest extends TestCase
{
    use DTOTestTrait;

    protected function getDTO(): DTOInterface
    {
        return new ViewItemEventData();
    }

    protected function getExpectedData(): array
    {
        return [
            'v' => '1',
            't' => 'event',
            'cid' => 'client_id',
            'ec' => 'engagement',
            'ea' => 'view_item',
            'pa' => 'detail',
            'tid' => 'UA-1234-1',
        ];
    }
}
