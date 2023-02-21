<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait;

use Setono\GoogleAnalyticsMeasurementProtocol\Attribute\Serialize;

trait HasValue
{
    #[Serialize]
    protected ?float $value = null;

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(?float $value): static
    {
        $this->value = $value;

        return $this;
    }
}
