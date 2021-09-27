<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\DTO;

use Setono\GoogleAnalyticsMeasurementProtocol\Hit\HitBuilder;
use Setono\GoogleAnalyticsMeasurementProtocol\Hit\HitBuilderInterface;

trait DTOTestTrait
{
    abstract protected function getDTO(): DTOInterface;

    /**
     * @return array<string, scalar>
     */
    abstract protected function getExpectedData(): array;

    /**
     * @test
     */
    public function it_applies(): void
    {
        $dto = $this->getDTO();
        $hitBuilder = new HitBuilder(HitBuilderInterface::HIT_TYPE_EVENT);
        $hitBuilder->setClientId('client_id');

        $dto->applyTo($hitBuilder);

        self::assertEquals($this->getExpectedData(), $hitBuilder->getHit('UA-1234-1')->getData());
    }

    /**
     * @test
     */
    public function it_throws_if_hit_type_is_not_event(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $dto = $this->getDTO();
        $hitBuilder = new HitBuilder(HitBuilderInterface::HIT_TYPE_PAGEVIEW);

        $dto->applyTo($hitBuilder);
    }
}
