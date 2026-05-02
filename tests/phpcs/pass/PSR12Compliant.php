<?php

declare(strict_types=1);

namespace Tests\PHPCS\Pass;

class PSR12Compliant
{
    public function __construct(private int $value)
    {
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function calculate(int $a, int $b): int
    {
        if ($a > $b) {
            return $a - $b;
        }

        return $b - $a;
    }
}
