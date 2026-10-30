#!/usr/bin/env bash
#
# Run PHPStan against fixtures that must be rejected, and assert that the errors
# are exactly the expected disallowed-call errors (and nothing unrelated).
#
# Usage (from tests/disallowed):
#   assert-errors.sh <phpstan config> <path> <expected message> <expected count> [<message> <count> ...]
#
# Each message is matched literally against the raw PHPStan output.

set -uo pipefail

cd "$(dirname "${BASH_SOURCE[0]}")"

config="$1"
path="$2"
shift 2

output=$(../../vendor/bin/phpstan analyse --memory-limit=2G --configuration="$config" --error-format=raw --no-progress "$path" 2>&1)
echo "$output"

status=0
expected_total=0

while [ "$#" -ge 2 ]; do
    message="$1"
    expected="$2"
    shift 2
    actual=$(grep -cF -- "$message" <<<"$output")
    if [ "$actual" -ne "$expected" ]; then
        echo "FAIL: expected $expected error(s) containing '$message', got $actual" >&2
        status=1
    fi
    expected_total=$((expected_total + expected))
done

# Every error line (path:line:message) must have been accounted for by an expected message.
actual_total=$(grep -cE '^/.+:[0-9]+:' <<<"$output")
if [ "$actual_total" -ne "$expected_total" ]; then
    echo "FAIL: expected $expected_total error(s) in total, got $actual_total (unrelated errors?)" >&2
    status=1
fi

exit "$status"
