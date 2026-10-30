<?php

declare(strict_types=1);

namespace App\EnvPass;

use App\Helpers\Environment;

class NormalCode
{
    public function isProd(): bool
    {
        return Environment::isProduction();
    }
}
