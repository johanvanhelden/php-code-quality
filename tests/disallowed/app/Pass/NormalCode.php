<?php

declare(strict_types=1);

namespace App\Pass;

class NormalCode
{
    public function name(): string
    {
        return strtoupper('normal code, no disallowed calls');
    }
}
