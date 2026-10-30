<?php

declare(strict_types=1);

namespace App\EnvFail;

use Illuminate\Support\ServiceProvider;

class ServiceProviderCalls extends ServiceProvider
{
    /** Must report: $this->app is typed as the Application contract. */
    #[\Override]
    public function register(): void
    {
        $this->app->environment('production');
    }
}
