<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Client\Response;

use Webmozart\Assert\Assert;

final class HitParsingResult
{
    /** @psalm-readonly */
    public bool $valid;

    /** @psalm-readonly */
    public string $hit;

    /**
     * If the hit is valid, this is an empty array
     *
     * @psalm-readonly
     *
     * @var array<array-key, string>
     */
    public array $errors;

    /**
     * @param array<array-key, string> $errors
     */
    public function __construct(bool $valid, string $hit, array $errors = [])
    {
        $this->valid = $valid;
        $this->hit = $hit;
        $this->errors = $errors;
    }

    /**
     * @param array<array-key, mixed> $data
     */
    public static function createFromArray(array $data): self
    {
        Assert::keyExists($data, 'valid', 'No "valid" key exists');
        Assert::boolean($data['valid']);
        Assert::keyExists($data, 'hit', 'No "hit" key exists');
        Assert::string($data['hit']);
        Assert::keyExists($data, 'parserMessage', 'No "parserMessage" key exists');
        Assert::isArray($data['parserMessage'], 'The "parserMessage" key is not an array');

        /** @var array<array-key, string> $errors */
        $errors = [];
        foreach ($data['parserMessage'] as $idx => $datum) {
            Assert::isArray($datum, sprintf('The item with idx %d on the "parserMessage" key is not an array', $idx));
            Assert::keyExists($datum, 'description', 'The key "description" does not exist the "parserMessage"');
            Assert::string($datum['description']);

            $errors[] = $datum['description'];
        }

        return new self($data['valid'], $data['hit'], $errors);
    }
}
