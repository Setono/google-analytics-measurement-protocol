<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait;

use Setono\GoogleAnalyticsMeasurementProtocol\Attribute\Serialize;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Event;

/**
 * @mixin Event
 */
trait HasAffiliation
{
    #[Serialize]
    protected ?string $affiliation = null;

    public function getAffiliation(): ?string
    {
        return $this->affiliation;
    }

    public function withAffiliation(?string $affiliation): self
    {
        return $this->with('affiliation', $affiliation);
    }
}
