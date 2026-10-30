# PHP Code Quality

> **Note:** This is a highly personal and opinionated set of PHP code quality rules and configurations that I use for my own projects. You're welcome to use it, but it's tailored to my specific preferences and may not suit everyone's needs.

This package contains my standardized PHP code quality rules and configurations for:

- **PHP_CodeSniffer (PHPCS)**: `rules/phpcs.xml`
- **PHP CS Fixer**: `rules/.php-cs-fixer.php`
- **PHPStan/Larastan**: `rules/phpstan.neon`
- **Disallowed calls** (`spaze/phpstan-disallowed-calls`): `rules/disallowed.neon` (always on) and `rules/disallowed/*.neon` (opt-in)
- **Rector**: `rules/rector.php`

## Usage

### Installation

Add the repository to your `composer.json`:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/johanvanhelden/php-code-quality"
    }
],
```

Then require the package:

```shell
composer require --dev johanvanhelden/php-code-quality
```

### PHPStan/Larastan

Create a `phpstan.neon` file in the root of the project with the following contents:

```
includes:
    - ./vendor/johanvanhelden/php-code-quality/rules/larastan.neon

parameters:
    ignoreErrors:
        - '#Any custom errors to ignore here#'
```

#### Disallowed calls

The package ships [spaze/phpstan-disallowed-calls](https://github.com/spaze/phpstan-disallowed-calls) and loads it through `rules/larastan.neon`, so every app that includes that file gets these rules:

- `dd()`, `dump()` and `var_dump()` are disallowed ("remove debugging calls")

`allowIn` paths (used by the opt-in file below and by your own rules) are resolved against the directory PHPStan is run from (not against the neon file), so use `%currentWorkingDirectory%`. Run PHPStan from the project root (as `make stan` does).

##### Opt-in: only check the environment through `App\Helpers\Environment`

For apps with the convention of checking the environment only through the class `App\Helpers\Environment` (`isProduction()`, `isLocal()`, `isTesting()`, `isDevelopment()`), add this line to the app's `phpstan.neon`:

```
includes:
    - ./vendor/johanvanhelden/php-code-quality/rules/larastan.neon
    - ./vendor/johanvanhelden/php-code-quality/rules/disallowed/environment.neon
```

It disallows `Illuminate\Support\Facades\App::environment()/isLocal()/isProduction()`, `Illuminate\Foundation\Application::environment()/isLocal()/isProduction()` and `Illuminate\Contracts\Foundation\Application::environment()`, except in `app/Helpers/Environment.php`.

What is caught (verified by the fixtures in `tests/disallowed/app/EnvFail`):

- `App::environment()` / `App::isProduction()` / `App::isLocal()` using the Laravel facade
- the same static calls through a subclass facade such as `App\Helpers\App extends Illuminate\Support\Facades\App` (reported as `... (as App\Helpers\App::environment())`)
- `app()->environment()`, `$app->isProduction()` on an `Illuminate\Foundation\Application` instance
- `$this->app->environment()` in a service provider (typed as the `Illuminate\Contracts\Foundation\Application` contract)

Not caught: `Illuminate\Support\Facades\App::currentEnvironmentIs()` and anything whose type PHPStan cannot infer (`mixed`). The `app()` helper is only caught when PHPStan resolves it to the `Application` class (Larastan does).

##### Adding your own rules in an app

Add the spaze parameters to the app's own `phpstan.neon`. Entries are merged with the ones from this package:

```
includes:
    - ./vendor/johanvanhelden/php-code-quality/rules/larastan.neon

parameters:
    disallowedFunctionCalls:
        -
            function: 'now()'
            message: 'Use Illuminate\Support\Facades\Date::now() instead'
    disallowedStaticCalls:
        -
            method: 'Illuminate\Support\Facades\DB::statement()'
            message: 'Use the query builder instead'
            allowIn:
                - %currentWorkingDirectory%/database/*
    disallowedMethodCalls:
        -
            method: 'Illuminate\Http\Request::all()'
            message: 'Use validated() or only() instead'
```

See the [spaze documentation](https://github.com/spaze/phpstan-disallowed-calls) for all options. Use `%currentWorkingDirectory%/...` for `allowIn` paths.

### PHP-CS-Fixer

Create a `.php-cs-fixer.php` file in the root of the project with the following contents:

```php
<?php

declare(strict_types=1);

use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

// Ignore Laravel's bootstrap/cache folder, but keep providers, app and any future files.
$finder->append(
    Finder::create()
        ->in(__DIR__ . '/bootstrap')
        ->exclude('cache')
        ->name('*.php')
        ->notName('*.blade.php')
);

/** @var PhpCsFixer\Config $config */
$config = include __DIR__ . '/vendor/johanvanhelden/php-code-quality/rules/.php-cs-fixer.php';

return $config->setFinder($finder);
```

### PHPCS

Create a `phpcs.xml` file in the root of the project with the following contents:

```xml
<?xml version="1.0"?>
<ruleset name="Application's PHPCS configuration">
    <file>./</file>

    <rule ref="vendor/johanvanhelden/php-code-quality/rules/phpcs.xml" />
</ruleset>
```

### Rector

Create a `rector.php` file in the root of the project with the following contents:

```php
<?php

declare(strict_types=1);

use Rector\Caching\ValueObject\Storage\FileCacheStorage;

$root = __DIR__;

/** @var \Rector\Configuration\RectorConfigBuilder $config */
$config = include __DIR__ . '/vendor/johanvanhelden/php-code-quality/rules/rector.php';

return $config
    ->withCache('/tmp/.cache/rector', FileCacheStorage::class) // optional, speeds up repeated runs
    ->withPaths([
        $root . '/app',
        $root . '/bootstrap',
        $root . '/config',
        $root . '/database',
        $root . '/lang',
        $root . '/public',
        $root . '/routes',
        $root . '/tests',
    ])
    ->withSkip([
        $root . '/bootstrap/cache',
    ]);
```

### Makefile

Include the Makefile in your project's main Makefile:

```makefile
-include vendor/johanvanhelden/php-code-quality/Makefile
```

Or copy the Makefile to your project root and use directly.

To run a collection of tools:

```bash
make validate-be     # Run all quality checks (for CI/CD usage)
make code-quality-be # Run syntax and static analysis checks
make code-style-be   # Run code style checks
make fix-be          # Auto-fix all code style and Rector issues
```

Or run each check separately:

```
make syntax          # Check syntax errors
make stan            # Run static analysis
make cs              # Check code style
make cs-fix          # Fix code style
make cs-fix-dry      # Dry run code style fixes (for CI/CD usage)
make rector          # Run Rector upgrades and refactors
make rector-dry      # Dry run Rector checks (for CI/CD usage)
```

#### Docker

The Makefile can automatically detect if commands are being executed in Docker or not. The PHP container needs to be called `php`.

The Makefile automatically detects the package directory and references the rule files accordingly.

## Using it in GitHub Actions

This is an example job:

```yaml
code-quality:
    name: Code Quality
    runs-on: ubuntu-latest

    steps:
        - uses: actions/checkout@v4

        - name: Set Up PHP and Tools
          uses: shivammathur/setup-php@v2
          with:
              php-version: "8.5"
              tools: composer:v2
              coverage: none

        - name: Cache Composer Dependencies
          uses: actions/cache@v3
          with:
              path: ./vendor
              key: ${{ runner.os }}-composer-${{ hashFiles('**/composer.lock') }}
              restore-keys: |
                  ${{ runner.os }}-composer-

        - name: Install Composer Dependencies
          run: composer install

        - name: Syntax Errors
          run: make syntax

        - name: PHP_CodeSniffer
          run: make cs

        - name: PHP-CS-Fixer
          run: make cs-fix-dry

        - name: Static Code Analysis
          run: make stan

        - name: Rector
          run: make rector-dry
```

## Visual Studio Code

Example settings for Visual Studio Code:

```json
"phpsab.executablePathCS": "vendor/bin/phpcs",

"php-cs-fixer.executablePath": "${workspaceFolder}/vendor/bin/php-cs-fixer",
"php-cs-fixer.config": ".php-cs-fixer.php",
```

## Local Development

Set the correct composer version:

```json
"require-dev": {
    "johanvanhelden/php-code-quality": "@dev",
}
```

And set up the repository configuration to point to your local package path:

```json
"repositories": [
    {
        "type": "path",
        "url": "../packages/php-code-quality"
    }
],
```

### Docker

Make sure the package is mounted in your Docker container, for example:

```yaml
volumes:
    # Other volumes
    - ../php-code-quality:/var/www/packages/php-code-quality:rw
```

## Developing This Package

This repository ships its own Docker setup so no PHP install is required on the host — the container matches the package's PHP requirement (`^8.5`).

Use `bin/dev` to run any command against the containerized PHP environment. It starts the container on demand and runs commands inside it; if you're already inside the container or running in CI, it runs the command directly instead.

```bash
bin/dev composer install              # Install dependencies
bin/dev composer test                 # Run the full test suite (see TESTING.md)
bin/dev composer test:cs              # Run an individual check
bin/dev vendor/bin/php-cs-fixer fix   # Auto-fix code style in this repo
```

To open a shell inside the container:

```bash
docker compose exec php bash
```

To stop the container:

```bash
docker compose down
```
