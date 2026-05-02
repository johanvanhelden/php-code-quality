<?php

declare(strict_types=1);

use Rector\Caching\ValueObject\Storage\FileCacheStorage;

$root = __DIR__;

/** @var \Rector\Configuration\RectorConfigBuilder $config */
$config = include __DIR__ . '/rules/rector.php';

return $config
    ->withCache('/tmp/.cache/rector', FileCacheStorage::class)
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
