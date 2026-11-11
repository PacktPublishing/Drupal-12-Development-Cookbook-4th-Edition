#!/bin/bash
# validate.sh -- Run all code quality checks for AI-generated (and human-written) code.
set -e

echo "Running PHPCS..."
ddev exec vendor/bin/phpcs --standard=Drupal,DrupalPractice \
  --extensions=php,module,inc,install,test,profile,theme \
  web/modules/custom/

echo "Running PHPStan..."
ddev exec vendor/bin/phpstan analyze \
  --configuration=phpstan.neon \
  --memory-limit=512M

echo "All checks passed!"
