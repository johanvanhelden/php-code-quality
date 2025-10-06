<?php

declare(strict_types=1);

use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__)
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

/** @var PhpCsFixer\Config $config */
$config = include __DIR__ . '/../rules/.php-cs-fixer.php';

return $config->setFinder($finder);
