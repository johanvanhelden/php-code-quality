# Test Suite

This directory contains test files to verify that the code quality tools are configured correctly.

## Structure

```
tests/
├── syntax/pass/          # Valid PHP syntax
├── syntax/fail/          # Invalid syntax (missing braces)
├── phpstan/pass/         # Type-safe code
├── phpstan/fail/         # Type violations
├── phpcs/pass/           # PSR-12 compliant
├── phpcs/fail/           # PSR-12 violations
├── php-cs-fixer/pass/    # Fixer compliant
├── php-cs-fixer/fail/    # Fixer violations
├── phpstan.neon          # PHPStan config
├── phpcs.xml             # PHPCS config
└── .php-cs-fixer.php     # PHP-CS-Fixer config
```

## Running Tests

```bash
composer test                 # Run all tests

# Config validation
composer test:config          # Validate config files
composer test:config:syntax   # Syntax check
composer test:config:stan     # PHPStan
composer test:config:cs-fix   # PHP-CS-Fixer

# Tool tests
composer test:syntax          # Syntax checker
composer test:stan            # PHPStan
composer test:cs              # PHPCS
composer test:cs-fix          # PHP-CS-Fixer
```

## How It Works

Each tool has both pass and fail test files:
- Pass files contain valid code that should be accepted
- Fail files contain invalid code that should be rejected

The `:fail` tests use inverted logic - they pass when the tool correctly detects errors.

## Adding Tests

1. Add a PHP file to the appropriate `pass` or `fail` directory
2. For fail files, add comments explaining the violations
3. Run the test to verify it works as expected
