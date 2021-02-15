<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

use Closure;
use function Safe\sprintf;
use Setono\GoogleAnalyticsMeasurementProtocol\Hit\Payload;
use Webmozart\Assert\Assert;

abstract class PayloadBuilder
{
    /** @var array<string, scalar> */
    protected array $data = [];

    protected function buildPayload(Closure $callback = null): Payload
    {
        $payload = new Payload();
        $mapping = $this->getPropertyMapping();

        foreach ($mapping as $parameter => $property) {
            if (!isset($this->data[$property])) {
                continue;
            }

            /** @var scalar $val */
            $val = $this->data[$property];

            if (null === $callback) {
                $payload->set($parameter, $val);
            } else {
                $callback($payload, $parameter, $val);
            }
        }

        return $payload;
    }

    /**
     * @return array<string, string>
     */
    abstract protected function getPropertyMapping(): array;

    /**
     * @param array<array-key, scalar> $arguments
     *
     * @return self|scalar|null
     */
    public function __call(string $method, array $arguments)
    {
        $accessorType = substr($method, 0, 3);
        $property = lcfirst(substr($method, 3));

        switch ($accessorType) {
            case 'set':
                return $this->set($property, $arguments[0]);
            case 'get':
                $this->assertPayloadPropertyExists($property);

                return $this->data[$property] ?? null;
            default:
                throw new \BadMethodCallException(sprintf(
                    'The method "%s" is not implemented. Use either set%s or get%s',
                    $method, ucfirst($property), ucfirst($property))
                );
        }
    }

    /**
     * @param mixed $value
     */
    protected function set(string $property, $value): self
    {
        $this->assertPayloadPropertyExists($property);
        Assert::scalar($value);

        $this->data[$property] = $value;

        return $this;
    }

    private function assertPayloadPropertyExists(string $property): void
    {
        if (!in_array($property, $this->getPropertyMapping(), true)) {
            throw new \InvalidArgumentException(sprintf('The property "%s" does not exist on this payload builder', $property));
        }
    }
}
