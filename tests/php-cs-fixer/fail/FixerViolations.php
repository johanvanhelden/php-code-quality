<?php
// Missing declare(strict_types=1)

namespace Tests\PhpCsFixer\Fail;

class FixerViolations
{
    // No blank line after opening tag
    private $items = array(); // Should use short array syntax []

    public function addItem($item)  {  // Extra spaces before brace
        $this->items[] = $item;
    }

    public function getItems()
    {


        // Too many blank lines above
        return $this->items;
    }

    public function concatenate($a,$b) { // Missing spaces after commas
        return $a.$b; // Missing spaces around concatenation operator
    }

    public function arrayAlignment() {
        return [
            'key1'   => 'value1',
            'key2' => 'value2', // Inconsistent alignment of =>
            'key3'    => 'value3'
        ];
    }
}
