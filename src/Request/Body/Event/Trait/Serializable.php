<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait;

use Setono\GoogleAnalyticsMeasurementProtocol\Attribute\Serialize;
use Webmozart\Assert\Assert;

trait Serializable
{
    /**
     * @return array<string, mixed>
     */
    protected function serialize(): array
    {
        /** @var array<string, mixed> $data */
        $data = [];
        $refl = new \ReflectionClass($this);

        $properties = $refl->getProperties();
        foreach ($properties as $property) {
            $attributes = $property->getAttributes(Serialize::class);
            if (count($attributes) < 1) {
                continue;
            }
            Assert::count($attributes, 1);

            /** @var Serialize $serialize */
            $serialize = $attributes[0]->newInstance();

            /** @psalm-suppress MixedAssignment */
            $data[$serialize->name ?? $property->getName()] = $property->getValue($this);
        }

        return array_filter($data);
    }
}
