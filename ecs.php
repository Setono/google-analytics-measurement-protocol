<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ECSConfig $config): void {
    $config->import(__DIR__ . '/vendor/sylius-labs/coding-standard/ecs.php');
    $config->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);
};
