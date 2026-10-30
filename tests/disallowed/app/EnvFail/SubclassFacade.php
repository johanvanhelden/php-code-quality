<?php

declare(strict_types=1);

namespace App\EnvFail;

use App\Helpers\App;

class SubclassFacade
{
    public function check(): void
    {
        App::environment('production');
        App::isProduction();
    }
}
