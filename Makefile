# ---------------------------------
# PHP Code Quality Tools
# ---------------------------------
# This Makefile contains all the code quality commands extracted from the main project

# Configuration
DOCKER_PHP_EXEC ?= docker compose exec php
PACKAGE_DIR := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

# Detect if running inside Docker or GitHub Actions
IN_DOCKER := $(shell [ -f /.dockerenv ] && echo "true" || echo "false")
IN_GITHUB_ACTIONS := $(shell if [ "$(CI)" = "true" ]; then echo "true"; else echo "false"; fi)

ifeq ($(IN_DOCKER),true)
    DOCKER_PHP_EXEC :=
else ifeq ($(IN_GITHUB_ACTIONS),true)
    DOCKER_PHP_EXEC :=
else
    DOCKER_PHP_EXEC := docker compose exec php
endif

.PHONY: $(filter-out vendor,$(MAKECMDGOALS))

# ---------------------------------
# Quality Assurance Commands
# ---------------------------------

validate-be: code-quality-be code-style-be

code-quality-be: syntax stan

code-style-be: cs cs-fix-dry

syntax:
	$(DOCKER_PHP_EXEC) find . -name "*.php" -not -path "./vendor/*" -not -path "./storage/*" -print0 | xargs -0 -n1 -P8 php -l

stan:
	$(DOCKER_PHP_EXEC) vendor/bin/phpstan analyse --memory-limit=2G --configuration=phpstan.neon -v

cs:
	$(DOCKER_PHP_EXEC) vendor/bin/phpcs --standard=phpcs.xml -ps --parallel=8

cs-fix:
	$(DOCKER_PHP_EXEC) vendor/bin/php-cs-fixer fix --diff --config=.php-cs-fixer.php

cs-fix-dry:
	$(DOCKER_PHP_EXEC) vendor/bin/php-cs-fixer fix --dry-run --diff --config=.php-cs-fixer.php
