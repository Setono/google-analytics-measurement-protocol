<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use PHPUnit\Framework\TestCase;

abstract class AbstractEventTestCase extends TestCase
{
    abstract protected function getEvent(): Event;

    abstract protected function getExpectedJson(): string;

    /**
     * @test
     */
    public function it_serializes(): void
    {
        self::assertSame($this->getExpectedJson(), json_encode($this->getEvent()));
    }
}
