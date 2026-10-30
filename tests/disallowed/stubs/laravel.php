<?php

declare(strict_types=1);

// Minimal stand-ins for laravel/framework classes and helpers that are not installed in this package.

namespace Illuminate\Foundation {
    use Illuminate\Contracts\Foundation\Application as ApplicationContract;

    class Application implements ApplicationContract
    {
        public function environment(...$environments)
        {
            return 'testing';
        }

        public function isLocal(): bool
        {
            return false;
        }

        public function isProduction(): bool
        {
            return false;
        }
    }
}

namespace {
    function app(): \Illuminate\Foundation\Application
    {
        return new \Illuminate\Foundation\Application();
    }

    function dd(mixed ...$vars): never
    {
        exit(1);
    }

    function dump(mixed ...$vars): void
    {
    }
}
