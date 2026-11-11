# AGENTS.md -- AI Agent Instructions for This Drupal Project

## Project Type
Drupal 12 website using DDEV and Composer.

## Directory Rules
- NEVER modify files in `vendor/`, `web/core/`, `web/modules/contrib/`, or `web/themes/contrib/`
- Custom code goes in `web/modules/custom/` or `web/themes/custom/`
- Configuration exports go in `config/sync/`

## Code Generation Rules
- Always use Drupal 12 conventions: PHP attributes, OOP hooks with #[Hook], constructor autowiring
- Always include `declare(strict_types=1);` in PHP files
- Always include proper PHPDoc blocks
- Use `\Drupal\Core\StringTranslation\TranslatableMarkup` (not `@Translation`)
- Generate configuration schema for any custom configuration
- Include a `README.md` for any new custom module

## Validation
After generating or modifying code, run: `bash scripts/validate.sh`
