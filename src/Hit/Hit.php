<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Hit;

final class Hit
{
    private string $propertyId;

    private string $clientId;

    /** @var array<string, scalar> */
    private array $data;

    private \DateTimeInterface $createdAt;

    /**
     * @param array<string, scalar> $data
     */
    public function __construct(string $propertyId, string $clientId, array $data, \DateTimeInterface $createdAt = null)
    {
        $this->propertyId = $propertyId;
        $this->clientId = $clientId;
        $this->data = $data;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
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
     * Returns the time when this Hit was instantiated
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * The payload is the string representation of the hit which is what you send to Google Analytics.
     *
     * NOTICE that the qt parameter is updated each time you call this method
     *
     * @param \DateTimeInterface|null $now Used to calculate the queue time. If no argument is given, it uses 'now'
     */
    public function getPayload(\DateTimeInterface $now = null): string
    {
        $str = '';

        $data = $this->getData();

        $qt = self::calculateQueueTime(
            $this->getCreatedAt(),
            $now ?? new \DateTimeImmutable()
        );

        if ($qt > 0) {
            $data[HitBuilderInterface::PARAMETER_QUEUE_TIME] = $qt;
        }

        foreach ($data as $key => $value) {
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

    private static function calculateQueueTime(\DateTimeInterface $then, \DateTimeInterface $now): int
    {
        $thenTimestamp = (int) round((float) $then->format('U.u') * 1000);
        $nowTimestamp = (int) round((float) $now->format('U.u') * 1000);

        return $nowTimestamp - $thenTimestamp;
    }
}
