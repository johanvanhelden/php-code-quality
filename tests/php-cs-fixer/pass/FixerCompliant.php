<?php

declare(strict_types=1);

namespace Tests\PhpCsFixer\Pass;

class FixerCompliant
{
    private array $items = [];

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
        $result = '';
        foreach ($this->items as $item) {
            $result .= $item . ' ';
        }

        return trim($result);
    }
}
