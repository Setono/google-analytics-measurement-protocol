<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Hit;

final class Hit
{
    private string $propertyId;

    private string $clientId;

    /** @var array<string, scalar> */
    private array $data;

    /**
     * @param array<string, scalar> $data
     */
    public function __construct(string $propertyId, string $clientId, array $data)
    {
        $this->propertyId = $propertyId;
        $this->clientId = $clientId;
        $this->data = $data;
    }

    public function getPropertyId(): string
    {
        return $this->propertyId;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @return array<string, scalar>
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * The payload is the string representation of the hit which is what you send to Google Analytics
     */
    public function getPayload(): string
    {
        $str = '';

        foreach ($this->getData() as $key => $value) {
            // if you cast false to string it returns '' (empty string) and not '0'
            if (is_bool($value)) {
                $value = (int) $value;
            }

            $str .= $key . '=' . rawurlencode((string) $value) . '&';
        }

        return rtrim($str, '&');
    }

    public function __toString(): string
    {
        return $this->getPayload();
    }
}
