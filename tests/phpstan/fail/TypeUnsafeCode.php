<?php

declare(strict_types=1);

namespace Tests\PHPStan\Fail;

class TypeUnsafeCode
{
    /**
     * PHPStan will complain: Method return type is mixed
     */
    public function getMixed()
    {
        return 'string or anything';
    }

    /**
     * PHPStan will complain: Parameter has no type
     */
    public function noParamType($value): string
    {
        return (string) $value;
    }

    /**
     * PHPStan will complain: Return type mismatch
     */
    public function wrongReturnType(): int
    {
        return 'this is a string, not int';
    }
}
