# Testing

The test suite validates that all code quality tools are configured correctly.

## Running Tests

```bash
composer test                 # Run all tests
composer test:config          # Validate config files
composer test:syntax          # Syntax checker
composer test:stan            # PHPStan
composer test:cs              # PHPCS
composer test:cs-fix          # PHP-CS-Fixer
```

## How It Works

Each tool has pass and fail test files:
- **Pass files** - Valid code that should be accepted
- **Fail files** - Invalid code that should be rejected

The fail tests use inverted logic (prefixed with `!`) so they pass when the tool correctly detects errors.

## Test Files

### Syntax Checker
- `tests/syntax/pass/ValidSyntax.php` - Valid class structure
- `tests/syntax/fail/InvalidSyntax.php` - Missing closing braces

### PHPStan
- `tests/phpstan/pass/TypeSafeCode.php` - Fully typed code
- `tests/phpstan/fail/TypeUnsafeCode.php` - Missing types, type mismatches

### PHPCS
- `tests/phpcs/pass/PSR12Compliant.php` - PSR-12 compliant
- `tests/phpcs/fail/PSR12Violations.php` - Spacing violations, missing declare statement

### PHP-CS-Fixer
- `tests/php-cs-fixer/pass/FixerCompliant.php` - All rules satisfied
- `tests/php-cs-fixer/fail/FixerViolations.php` - Array syntax, spacing, alignment issues

## Adding Tests

1. Add a PHP file to the appropriate `pass` or `fail` directory
2. For fail files, add comments explaining what rules are violated
3. Run the test to verify it works
