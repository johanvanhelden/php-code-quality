<?php

declare(strict_types=1);

namespace JohanVanHelden\PhpCodeQuality\PHPStan;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * Require that ->where('foo', 'bar') be spelled ->where('foo', '=', 'bar').
 *
 * @implements Rule<MethodCall>
 */
class NoImplicitOperatorInQueryMethodRule implements Rule
{
    private const array IGNORED_CALLER_CLASSES = [
        'Illuminate\Validation\Rules\Exists',
        'Illuminate\Validation\Rules\Unique',
        'Inertia\Testing\AssertableInertia',
    ];

    private const array CHECK_METHODS = [
        'where',
        'orWhere',
        'whereAll',
        'orWhereAll',
        'whereAny',
        'orWhereAny',
        'having',
        'orHaving',
        'whereNot',
        'orWhereNot',

        // JSON methods
        'whereJsonLength',
        'orWhereJsonLength',

        // Date methods
        'whereDate',
        'orWhereDate',
        'whereTime',
        'orWhereTime',
        'whereDay',
        'orWhereDay',
        'whereMonth',
        'orWhereMonth',
        'whereYear',
        'orWhereYear',
    ];

    #[\Override]
    public function getNodeType(): string
    {
        return MethodCall::class;
    }

    /** @param MethodCall $node */
    #[\Override]
    public function processNode(Node $node, Scope $scope): array
    {
        if ($this->shouldSkipNode($node) || $this->shouldIgnoreCaller($node, $scope)) {
            return [];
        }

        if (count($node->args) !== 2) {
            return [];
        }

        return [
            RuleErrorBuilder::message(
                'Always specify the operator explicitly.'
                . " Instead of ->where('foo', 'bar') write ->where('foo', '=', 'bar').",
            )
                ->identifier('NoImplicitOperatorInQueryMethodRule')
                ->build(),
        ];
    }

    /** @param MethodCall $node */
    private function shouldSkipNode(Node $node): bool
    {
        return !isset($node->name)
            || !isset($node->name->name)
            || !in_array($node->name->name, self::CHECK_METHODS, true);
    }

    /** @param MethodCall $node */
    private function shouldIgnoreCaller(Node $node, Scope $scope): bool
    {
        $callerType = $scope->getType($node->var);

        foreach ($callerType->getReferencedClasses() as $referencedClass) {
            if (in_array($referencedClass, self::IGNORED_CALLER_CLASSES, true)) {
                return true;
            }
        }

        return false;
    }
}
