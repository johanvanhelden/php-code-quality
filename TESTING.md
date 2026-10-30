# Testing

The test suite validates that all code quality tools are configured correctly.

## Running Tests

```bash
composer test                 # Run all tests
composer test:config          # Validate config files
composer test:syntax          # Syntax checker
composer test:stan            # PHPStan (incl. disallowed calls)
composer test:stan:disallowed # Only the disallowed-calls tests
composer test:cs              # PHPCS
composer test:cs-fix          # PHP-CS-Fixer
```

## How It Works

Each tool has pass and fail test files:
- **Pass files** - Valid code that should be accepted
- **Fail files** - Invalid code that should be rejected

The fail tests use inverted logic (prefixed with `!`) so they pass when the tool correctly detects errors.

The disallowed-calls tests are stricter: `tests/disallowed/assert-errors.sh` greps the PHPStan output for the specific disallowed message and asserts the exact number of occurrences and that there are no other errors, so they cannot pass because of an unrelated error.

## Test Files

### Syntax Checker
- `tests/syntax/pass/ValidSyntax.php` - Valid class structure
- `tests/syntax/fail/InvalidSyntax.php` - Missing closing braces

### PHPStan
- `tests/phpstan/pass/TypeSafeCode.php` - Fully typed code
- `tests/phpstan/fail/TypeUnsafeCode.php` - Missing types, type mismatches

### PHPStan disallowed calls (`tests/disallowed`)
This directory is a miniature Laravel-style app root; the tests run PHPStan from inside it so `%currentWorkingDirectory%/app/Helpers/Environment.php` (the opt-in `allowIn`) resolves like in a real app. Larastan itself cannot boot here (no `laravel/framework`), so `tests/phpstan.neon` loads the extension and `rules/disallowed.neon` directly, using the same `%rootDir%/../../../vendor/...` path as `rules/larastan.neon`. Laravel classes that are not installed are stubbed in `stubs/laravel.php`.
- `phpstan.neon` - always-on rules; `phpstan-environment.neon` - additionally the opt-in `rules/disallowed/environment.neon`
- `app/Pass/`, `app/Helpers/` (stub `App\Helpers\Environment` and subclass facade `App\Helpers\App`), `app/EnvPass/` - accepted
- `app/EnvFail/` - also accepted by the always-on config (the opt-in is not active)
- `app/Fail/` - `dd()`/`dump()`/`var_dump()` (3x) must be rejected with the specific message
- `app/EnvFail/` with the opt-in config - 10 specific rejections: facade, subclass facade, `app()->environment()`, `$app->isProduction()`, contract and `$this->app->environment()` in a service provider

Scripts: `test:stan:disallowed:pass`, `:fail`, `:environment:pass`, `:environment:fail`.

### PHPCS
- `tests/phpcs/pass/PSR12Compliant.php` - PSR-12 compliant
- `tests/phpcs/fail/PSR12Violations.php` - Spacing violations, missing declare statement

### PHP-CS-Fixer
- `tests/php-cs-fixer/pass/FixerCompliant.php` - All rules satisfied
- `tests/php-cs-fixer/fail/FixerViolations.php` - Array syntax, spacing, alignment issues

## Adding Tests

1. Add a PHP file to the appropriate `pass` or `fail` directory (for disallowed calls: `tests/disallowed/app/...` and update the expected counts in the `composer.json` script)
2. For fail files, add comments explaining what rules are violated
3. Run the test to verify it works
