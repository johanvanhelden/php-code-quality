# PHP Code Quality

> **Note:** This is a highly personal and opinionated set of PHP code quality rules and configurations that I use for my own projects. You're welcome to use it, but it's tailored to my specific preferences and may not suit everyone's needs.

This package contains my standardized PHP code quality rules and configurations for:

- **PHP_CodeSniffer (PHPCS)**: `rules/phpcs.xml`
- **PHP CS Fixer**: `rules/.php-cs-fixer.php`
- **PHPStan/Larastan**: `rules/phpstan.neon`

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

### PHP-CS-Fixer

Create a `.php-cs-fixer.php` file in the root of the project with the following contents:

```php
<?php

declare(strict_types=1);

use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in([
        'app',
        'config',
        'database',
        'routes',
        'tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

// Ignore Laravel's bootstrap/cache folder, but keep providers, app and any future files.
$finder->append(
    Finder::create()
        ->in('bootstrap')
        ->exclude('cache')
        ->name('*.php')
        ->notName('*.blade.php')
);

/** @var PhpCsFixer\Config $config */
$config = include 'vendor/johanvanhelden/php-code-quality/rules/.php-cs-fixer.php';

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
```

Or run each check separately:
```
make syntax          # Check syntax errors
make stan            # Run static analysis
make cs              # Check code style
make cs-fix          # Fix code style
make cs-fix-dry      # Dry run code style fixes (for CI/CD usage)
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
          php-version: '8.4'
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
```

## Visual Studio Code

Example settings for Visual Studio Code:

```json
"phpsab.executablePathCS": "vendor/bin/phpcs",

"php-cs-fixer.executablePath": "${workspaceFolder}/vendor/bin/php-cs-fixer",
"php-cs-fixer.config": "${workspaceFolder}/.php-cs-fixer.php"
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

