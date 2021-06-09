<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Client\Response;

use Webmozart\Assert\Assert;

final class DebugResponse implements ResponseInterface
{
    private ResponseInterface $decorated;

    /** @var array<array-key, HitParsingResult> */
    private array $hitParsingResults = [];

    public function __construct(ResponseInterface $response)
    {
        $this->decorated = $response;

        $data = json_decode($response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        Assert::isArray($data, 'The response could not be decoded to an array');
        Assert::keyExists($data, 'hitParsingResult', 'The key "hitParsingResult" does not exist on the response array');
        Assert::isArray($data['hitParsingResult'], 'The key "hitParsingResult" is not an array');

        foreach ($data['hitParsingResult'] as $idx => $datum) {
            Assert::isArray($datum, sprintf('The item on index %d is not an array', $idx));

            $this->hitParsingResults[] = HitParsingResult::createFromArray($datum);
        }
    }

    public function getStatusCode(): int
    {
        return $this->decorated->getStatusCode();
    }

    public function getBody(): string
    {
        return $this->decorated->getBody();
    }

    /**
     * @return array<array-key, HitParsingResult>
     */
    public function getHitParsingResults(): array
    {
        return $this->hitParsingResults;
    }

    /**
     * Returns true if all hits were valid
     */
    public function wasValid(): bool
    {
        foreach ($this->getHitParsingResults() as $hitParsingResult) {
            if (!$hitParsingResult->valid) {
                return false;
            }
        }

        return true;
    }

    public function getErrors(): array
    {
        $errors = [];
        foreach ($this->getHitParsingResults() as $hitParsingResult) {
            $errors = array_merge($errors, $hitParsingResult->errors);
        }

        return $errors;
    }
}
