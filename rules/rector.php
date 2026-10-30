<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\ClassMethod\OptionalParametersAfterRequiredRector;
use Rector\Config\RectorConfig;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;
use Rector\Php82\Rector\Class_\ReadOnlyClassRector;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\SafeDeclareStrictTypesRector;

return RectorConfig::configure()
    ->withSkip([
        ClosureToArrowFunctionRector::class,
        ReadOnlyPropertyRector::class,
        OptionalParametersAfterRequiredRector::class,
        ReadOnlyClassRector::class,
        '*/vendor/*',
    ])
    ->withPhpSets()
    ->withRules([
        SafeDeclareStrictTypesRector::class,
    ])
    ->withParallel(240, (int) (shell_exec('nproc') ?: 2));
