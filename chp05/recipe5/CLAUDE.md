# Project Context for AI Agents

## Drupal Version
- Drupal 12.x
- PHP 8.5+
- Drush 13

## Architecture
- Project root: this directory
- Web root: `web/`
- Custom modules: `web/modules/custom/`
- Custom themes: `web/themes/custom/`
- Configuration sync: `config/sync/`
- Composer manages all dependencies

## Coding Standards
- Follow Drupal coding standards
- Use PHP attributes for plugins (NOT annotations)
- Prefer OOP hooks with #[Hook] attributes over procedural .module hooks
- Use constructor dependency injection with autowiring
- Use `new TranslatableMarkup()` instead of `@Translation()`

## Key Conventions
- Module machine names: snake_case
- Class names: PascalCase
- Route names: module_name.route_name
- All custom code must pass PHPCS with Drupal and DrupalPractice standards
- All custom code should pass PHPStan at level 5+

## Commands
- Run Drush: `ddev drush <command>`
- Run Composer: `ddev composer <command>`
- Clear caches: `ddev drush cr`
- Export config: `ddev drush cex -y`
- Import config: `ddev drush cim -y`
- Run PHPCS: `ddev exec vendor/bin/phpcs --standard=Drupal,DrupalPractice web/modules/custom/`
- Run PHPStan: `ddev exec vendor/bin/phpstan analyze web/modules/custom/`
