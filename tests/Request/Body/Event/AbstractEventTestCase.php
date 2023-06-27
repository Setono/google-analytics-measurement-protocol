<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use PHPUnit\Framework\TestCase;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Request;

abstract class AbstractEventTestCase extends TestCase
{
    abstract protected function getEvent(): Event;

    abstract protected function getExpectedServerSideJson(): string;

    abstract protected function getExpectedClientSideJson(): string;

    abstract protected function getExpectedClientSideTagManagerJson(): string;

    /**
     * @test
     */
    public function it_serializes_for_server_side(): void
    {
        self::assertSame(
            $this->getExpectedServerSideJson(),
            json_encode($this->getEvent()->getPayload(), \JSON_THROW_ON_ERROR)
        );
    }

    /**
     * @test
     */
    public function it_serializes_for_client_side(): void
    {
        self::assertSame(
            $this->getExpectedClientSideJson(),
            json_encode($this->getEvent()->getPayload(Request::TRACKING_CONTEXT_CLIENT_SIDE), \JSON_THROW_ON_ERROR)
        );
    }

    /**
     * @test
     */
    public function it_serializes_for_client_side_tag_manager(): void
    {
        self::assertSame(
            $this->getExpectedClientSideTagManagerJson(),
            json_encode($this->getEvent()->getPayload(Request::TRACKING_CONTEXT_CLIENT_SIDE_TAG_MANAGER), \JSON_THROW_ON_ERROR)
        );
    }
}
