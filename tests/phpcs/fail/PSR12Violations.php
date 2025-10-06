<?php

// Missing declare(strict_types=1)
namespace Tests\PHPCS\Fail;

class PSR12Violations {
    // Opening brace should be on next line

    private $untyped_value; // Should have type declaration

    public function badFormatting($param1,$param2) // Missing spaces after commas
    {
        if($param1>$param2){return $param1;} // Multiple violations: spacing, inline statement

        return $param2;
    }

    // Line too long (over 120 characters) - will trigger LineLength rule
    public function veryLongMethodNameThatWillCauseTheLineToExceedTheMaximumAllowedLengthWhenCombinedWithParametersAndReturnTypes(string $parameter): string
    {
        return $parameter;
    }
}
