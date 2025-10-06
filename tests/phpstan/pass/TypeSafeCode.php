<?php

declare(strict_types=1);

namespace Tests\PHPStan\Pass;

class TypeSafeCode
{
    private int $count = 0;

    public function increment(): void
    {
        $this->count++;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param array<string> $items
     * @return array<string>
     */
    public function processArray(array $items): array
    {
        $result = [];
        foreach ($items as $item) {
            $result[] = strtoupper($item);
        }

        return $result;
    }
}
