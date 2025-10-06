<?php

declare(strict_types=1);

namespace Tests\Syntax\Pass;

class ValidSyntax
{
    public function add(int $a, int $b): int
    {
        return $a + $b;
    }

    public function greet(string $name): string
    {
        return "Hello, {$name}!";
    }
}
