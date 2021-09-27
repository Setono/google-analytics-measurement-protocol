<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Hit;

use Webmozart\Assert\Assert;

final class Hit
{
    /** @var array<string, scalar> */
    private array $data;

    private \DateTimeInterface $timestamp;

    /**
     * @param array<string, scalar> $data
     * @param \DateTimeInterface|null $timestamp if you want to set the time when the hit happened, use this argument
     */
    public function __construct(array $data, \DateTimeInterface $timestamp = null)
    {
        Assert::keyExists($data, HitBuilderInterface::PARAMETER_CLIENT_ID);
        Assert::string($data[HitBuilderInterface::PARAMETER_CLIENT_ID]);
        Assert::keyExists($data, HitBuilderInterface::PARAMETER_PROPERTY_ID);
        Assert::string($data[HitBuilderInterface::PARAMETER_PROPERTY_ID]);

        $this->data = $data;
        $this->timestamp = $timestamp ?? new \DateTimeImmutable();
    }

    public function getPropertyId(): string
    {
        return $this->data[HitBuilderInterface::PARAMETER_PROPERTY_ID];
    }

    public function getClientId(): string
    {
        return $this->data[HitBuilderInterface::PARAMETER_CLIENT_ID];
    }

    /**
     * @return array<string, scalar>
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Returns the time when this Hit happened
     */
    public function getTimestamp(): \DateTimeInterface
    {
        return $this->timestamp;
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
            $this->getTimestamp(),
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
