<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Validator;

use Setono\GoogleAnalyticsMeasurementProtocol\Builder\HitBuilderInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

interface ValidatorInterface
{
    public function validate(HitBuilderInterface $hitBuilder): ConstraintViolationListInterface;
}
