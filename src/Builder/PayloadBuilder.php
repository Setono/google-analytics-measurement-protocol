<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

use function Safe\json_encode;
use Setono\GoogleAnalyticsMeasurementProtocol\Event\EventInterface;

final class PayloadBuilder
{
    public string $clientId;

    public string $userId;

    public int $timestampMicros;

    public array $userProperties = [];

    public bool $nonPersonalizedAds;

    /** @var EventInterface[] */
    public array $events = [];

    public function __construct()
    {
        $this->timestampMicros = (int) (microtime(true) * 1_000_000);
    }

    public function toArray(): array
    {
        $arr = [];

        if (isset($this->clientId)) {
            $arr['client_id'] = $this->clientId;
        }

        if (isset($this->userId)) {
            $arr['user_id'] = $this->userId;
        }

        if (isset($this->timestampMicros)) {
            $arr['timestamp_micros'] = $this->timestampMicros;
        }

        if (isset($this->nonPersonalizedAds)) {
            $arr['non_personalized_ads'] = $this->nonPersonalizedAds;
        }

        foreach ($this->events as $event) {
            $arr['events'][] = $event->toArray();
        }

        // todo missing $this->userProperties

        return $arr;
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
