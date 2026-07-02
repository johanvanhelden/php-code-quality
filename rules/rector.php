<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\ClassMethod\OptionalParametersAfterRequiredRector;
use Rector\Config\RectorConfig;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Php81\Rector\FuncCall\NullToStrictStringFuncCallArgRector;
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;
use Rector\Php82\Rector\Class_\ReadOnlyClassRector;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\DeclareStrictTypesRector;

return RectorConfig::configure()
    ->withSkip([
        ClosureToArrowFunctionRector::class,
        ReadOnlyPropertyRector::class,
        OptionalParametersAfterRequiredRector::class,
        ReadOnlyClassRector::class,
        NullToStrictStringFuncCallArgRector::class,
        '*/vendor/*',
    ])
    ->withPhpSets()
    ->withRules([
        DeclareStrictTypesRector::class,
    ])
    ->withConfiguredRule(AddOverrideAttributeToOverriddenMethodsRector::class, [
        'allow_override_empty_method' => true,
    ])
    ->withParallel(240, (int) (shell_exec('nproc') ?: 2));
