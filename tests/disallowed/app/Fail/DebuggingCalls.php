<?php

declare(strict_types=1);

namespace App\Fail;

class DebuggingCalls
{
    /**
     * Must report three times: remove debugging calls.
     */
    public function debug(string $value): void
    {
        dump($value);
        var_dump($value);
        dd($value);
    }
}
