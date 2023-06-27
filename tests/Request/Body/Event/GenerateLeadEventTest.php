<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\GenerateLeadEvent
 */
final class GenerateLeadEventTest extends AbstractEventTestCase
{
    protected function getEvent(): Event
    {
        return GenerateLeadEvent::create()
            ->setCurrency('USD')
            ->setValue(123.45)
        ;
    }

    protected function getExpectedServerSideJson(): string
    {
        return '{"name":"generate_lead","params":{"currency":"USD","value":123.45}}';
    }

    protected function getExpectedClientSideJson(): string
    {
        return '{"currency":"USD","value":123.45}';
    }

    protected function getExpectedClientSideTagManagerJson(): string
    {
        return '{"currency":"USD","value":123.45,"event":"generate_lead"}';
    }
}
