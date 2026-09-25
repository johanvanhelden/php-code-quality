<?php

declare(strict_types=1);

namespace Tests\PhpCsFixer\Pass;

use DateTimeImmutable;
use RuntimeException;

use function array_map;

class FixerCompliant
{
    private array $items = [];

    public function currentDate(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }

    public function addItem(string $item): void
    {
        $this->items[] = $item;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function process(): string
    {
        if ($this->items === []) {
            throw new RuntimeException('At least one item is required.');
        }

        return implode(' ', array_map(
            static fn (string $item): string => $item,
            $this->items,
        ));
    }
}
