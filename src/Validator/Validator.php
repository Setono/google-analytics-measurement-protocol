<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Validator;

use Setono\GoogleAnalyticsMeasurementProtocol\Builder\HitBuilderInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface as SymfonyValidator;

final class Validator implements ValidatorInterface
{
    private SymfonyValidator $validator;

    public function __construct(SymfonyValidator $validator = null)
    {
        $this->validator = $validator ?? Validation::createValidatorBuilder()
                ->addXmlMapping(__DIR__ . '/../Resources/config/validation/HitBuilder.xml')
                ->getValidator();
    }

    public function validate(HitBuilderInterface $hitBuilder): ConstraintViolationListInterface
    {
        return $this->validator->validate($hitBuilder);
    }
}
