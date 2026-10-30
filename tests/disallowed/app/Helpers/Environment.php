<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Facades\App;

/**
 * Stub of the app-level helper. It is the one place allowed to ask the framework for the environment.
 */
class Environment
{
    public static function isProduction(): bool
    {
        return App::environment('production') === true;
    }

    public static function isLocal(): bool
    {
        return App::isLocal() || app()->isLocal();
    }
}
