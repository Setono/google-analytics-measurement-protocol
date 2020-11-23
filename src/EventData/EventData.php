<?php
declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\EventData;

use ReflectionClass;
use ReflectionProperty;
use Symfony\Component\String\UnicodeString;

abstract class EventData implements EventDataInterface
{
    public function toArray(): array
    {
        $arr = [];

        $reflectionClass = new ReflectionClass($this);
        $properties = $reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            $propertyName = new UnicodeString($property->getName());

            $arr[(string) $propertyName->snake()] = $this->{$propertyName};
        }

        return $arr;
    }
}
