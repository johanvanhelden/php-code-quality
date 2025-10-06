<?php

declare(strict_types=1);

namespace Tests\PHPCS\Pass;

class PSR12Compliant
{
    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
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
