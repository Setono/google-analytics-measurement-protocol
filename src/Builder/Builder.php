<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

use Closure;
use RuntimeException;
use function Safe\sprintf;

/**
 * @psalm-consistent-constructor
 */
abstract class Builder implements BuilderInterface
{
    public function getQuery(): string
    {
        if (!defined(static::class . '::PROPERTY_MAPPING')) {
            return '';
        }

        /** @var array<int|string, string> $propertyMapping */
        $propertyMapping = static::PROPERTY_MAPPING;

        $q = $this->buildQuery($propertyMapping, function (?string $parameter, string $value): string {
            if (null === $parameter) {
                return $value . '&';
            }

            return sprintf('%s=%s&', $parameter, $value);
        });

        return rtrim($q, '&');
    }

    public static function createFromString(string $q): BuilderInterface
    {
        $obj = new static();
        if ('' === $q) {
            return $obj;
        }

        if (!defined(static::class . '::PROPERTY_MAPPING')) {
            return $obj;
        }

        /** @var array<string, string> $propertyMapping */
        $propertyMapping = static::PROPERTY_MAPPING;

        parse_str($q, $parameters);

        /**
         * @var string $parameter
         * @var string $value
         */
        foreach ($parameters as $parameter => $value) {
            if (!isset($propertyMapping[$parameter])) {
                continue;
            }

            /** @var string $property */
            $property = $propertyMapping[$parameter];
            $reflectionProperty = new \ReflectionProperty($obj, $property);
            $reflectionType = $reflectionProperty->getType();
            if (null !== $reflectionType) {
                $propertyType = $reflectionType->getName();
                switch ($propertyType) {
                    case 'int':
                        $value = (int) $value;

                        break;
                    case 'float':
                        $value = (float) $value;

                        break;
                    case 'bool':
                        $value = (bool) $value;

                        break;
                }
            }

            $obj->{$property} = $value;
        }

        return $obj;
    }

    public function __toString(): string
    {
        return $this->getQuery();
    }

    /**
     * @param array<string|int, string> $mapping
     */
    protected function buildQuery(array $mapping, Closure $callback): string
    {
        $q = '';

        foreach ($mapping as $parameter => $property) {
            if (!isset($this->{$property})) {
                continue;
            }

            /** @var mixed $val */
            $val = $this->{$property};

            if (!is_scalar($val) && !is_object($val)) {
                throw new RuntimeException(sprintf(
                    'The property %s can only be a scalar or an object', $property
                ));
            }

            // if you cast false to string it returns '' (empty string) and not '0'
            if (is_bool($val) && false === $val) {
                $val = '0';
            }

            if (is_object($val) && !method_exists($val, '__toString')) {
                throw new RuntimeException(sprintf(
                    'The class %s must implement the __toString method', get_class($val)
                ));
            }

            /**
             * if the parameter is an integer we assume that the user doesn't want to output the parameter
             * and hence we supply a null value for the parameter instead
             *
             * @var mixed $res
             * @psalm-suppress PossiblyInvalidCast See https://github.com/vimeo/psalm/issues/4569
             */
            $res = $callback(is_string($parameter) ? $parameter : null, (string) $val);

            if (!is_string($res)) {
                throw new RuntimeException('The callback must always return a string');
            }

            $q .= $res;
        }

        return $q;
    }
}
