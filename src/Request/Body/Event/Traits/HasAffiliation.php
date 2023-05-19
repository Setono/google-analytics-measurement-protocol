<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits;

trait HasAffiliation
{
    protected ?string $affiliation = null;

    public function getAffiliation(): ?string
    {
        return $this->affiliation;
    }

    /**
     * @return static
     */
    public function setAffiliation(?string $affiliation): self
    {
        $this->affiliation = $affiliation;

        return $this;
    }
}
