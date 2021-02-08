<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Hit;

final class Payload
{
    /** @var array<string, scalar> */
    private array $payload = [];

    /**
     * @param mixed $value
     */
    public function set(string $key, $value): self
    {
        if (!is_scalar($value)) {
            throw new \InvalidArgumentException('Wrong type given. A payload value can only be a scalar (int, float, string or bool)');
        }

        $this->payload[$key] = $value;

        return $this;
    }

    /**
     * @return mixed|null
     */
    public function get(string $key)
    {
        return $this->payload[$key] ?? null;
    }

    /**
     * @return array<array-key, string>
     */
    public function keys(): array
    {
        return array_keys($this->payload);
    }

    public function mergePayload(self $payload): self
    {
        $keys = $payload->keys();

        foreach ($keys as $key) {
            $this->set($key, $payload->get($key));
        }

        return $this;
    }

    /**
     * Returns the payload as a string
     */
    public function getValue(): string
    {
        $str = '';

        foreach ($this->payload as $key => $value) {
            // if you cast false to string it returns '' (empty string) and not '0'
            if (is_bool($value) && false === $value) {
                $value = '0';
            }

            $str .= $key . '=' . $value . '&';
        }

        return rtrim($str, '&');
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
