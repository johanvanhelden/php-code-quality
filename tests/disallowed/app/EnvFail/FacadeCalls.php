<?php

declare(strict_types=1);

namespace App\EnvFail;

use Illuminate\Support\Facades\App;

class FacadeCalls
{
    /** Must report three times. */
    public function check(): void
    {
        App::environment('production');
        App::isProduction();
        App::isLocal();
    }
}
