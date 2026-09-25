<?php

declare(strict_types=1);

namespace Tests\PHPCS\Pass;

use DateTimeImmutable;
use RuntimeException;

use function array_map;

class PSR12Compliant
{
    public function __construct(private int $value)
    {
    }

    public function currentDate(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }

    public function getValue(): int
    {
        if ($this->value < 0) {
            throw new RuntimeException('The value cannot be negative.');
        }

        return $this->value;
    }

    public function calculate(int $a, int $b): int
    {
        if ($a > $b) {
            return $a - $b;
        }

        return $b - $a;
    }

    /**
     * @param array<int> $values
     *
     * @return array<int>
     */
    public function mapValues(array $values): array
    {
        return array_map(
            static fn (int $value): int => $value,
            $values,
        );
    }
}
