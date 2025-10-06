<?php

declare(strict_types=1);

namespace Tests\Syntax\Fail;

class InvalidSyntax
{
    public function broken(int $a, int $b): int
    {
        // Missing closing brace - syntax error
        return $a + $b;
    // Missing closing brace for method

// Missing closing brace for class
