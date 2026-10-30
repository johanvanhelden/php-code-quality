<?php

declare(strict_types=1);

namespace App\EnvFail;

use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use Illuminate\Foundation\Application;

class ApplicationCalls
{
    /** Must report: app()->environment() and the Application instance methods. */
    public function check(Application $app, ApplicationContract $contract): void
    {
        app()->environment('production');
        $app->isProduction();
        $app->isLocal();
        $contract->environment('production');
    }
}
