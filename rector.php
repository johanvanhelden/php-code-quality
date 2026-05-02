<?php

declare(strict_types=1);

$root = __DIR__;

/** @var \Rector\Configuration\RectorConfigBuilder $config */
$config = include __DIR__ . '/rules/rector.php';

return $config
    ->withPaths([
        $root . '/rules',
        $root . '/tests',
    ])
    ->withSkip([
        $root . '/tests/syntax',
        $root . '/tests/php-cs-fixer/fail',
        $root . '/tests/phpcs/fail',
        $root . '/tests/phpstan/fail',
        $root . '/tests/rector/fail',
    ]);
