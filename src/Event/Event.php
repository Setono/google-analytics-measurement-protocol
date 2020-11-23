<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

abstract class Event implements EventInterface
{
    protected string $name;

    public EventParametersInterface $parameters;

    public function toArray(): array
    {
        $arr = ['name' => $this->name];

        if (isset($this->parameters)) {
            $arr['params'] = $this->parameters->toArray();
        }

        return $arr;
    }
}
