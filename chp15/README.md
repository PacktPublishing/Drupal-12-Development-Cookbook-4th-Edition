# Chapter 15 — Testing Your Drupal Site

Code for this chapter is a single custom module plus PHPUnit configuration and
Playwright end-to-end specs, rather than the per-recipe `mymodule/` layout — the
`chapter15` module is built up across recipes 2–4 and its tests are run together.

## Layout

```
chp15/
  phpunit.xml                          # copied from core's phpunit.xml.dist, edited per Recipe 1
  playwright.config.ts                 # Playwright config (Chromium/Firefox/WebKit) — Recipe 5
  web/modules/custom/chapter15/
    chapter15.info.yml
    src/CamelCase.php                   # snake_case -> camelCase utility (Recipe 2)
    src/Plugin/Field/FieldFormatter/
      CamelCaseFormatter.php            # field formatter using CamelCase (Recipe 3)
    tests/src/Unit/CamelCaseTest.php            # unit test (Recipe 2)
    tests/src/Kernel/CamelCaseFormatterTest.php # kernel test (Recipe 3)
    tests/src/Functional/CamelCaseFormatterDisplayTest.php  # functional test (Recipe 4)
  tests/playwright/
    camelcase-formatter.spec.ts
    drupal-login.spec.ts
    content-listing.spec.ts             # beforeEach login hook + selectOption() filter (There's more)
    auth.setup.ts                       # reusable authenticated-state setup (There's more)
  .github/workflows/
    playwright.yml                      # CI workflow: install browsers, run suite, upload report
```

## Running the tests

Copy `phpunit.xml` to your project root and the `chapter15` module into
`web/modules/custom/`, then:

```bash
ddev exec vendor/bin/phpunit --testsuite unit
ddev exec vendor/bin/phpunit --testsuite kernel
ddev exec vendor/bin/phpunit --testsuite functional
```

For the Playwright specs, copy `playwright.config.ts` and `tests/playwright/`
into your project, install Playwright, and run:

```bash
ddev exec "DRUPAL_BASE_URL=https://your-site.ddev.site npx playwright test"
```

The PHPUnit suites were run against Drupal 12.0.0-beta2 with PHP 8.5 and
PHPUnit 12.5 (`drupal/core-dev:^12@beta`; unit 5 tests, kernel 1 test,
functional 3 tests, all passing). Install core with source checkout
(`composer reinstall drupal/core --prefer-source`) if `web/core/tests` is missing
from the dist package. The five Playwright specs also passed (Chromium, Node 24,
Playwright latest) against a fresh Drupal 12.0.0-beta2 standard install. Because
Standard no longer creates a Basic page type, create a `page` content type, add
the `field_chapter15_test` string field with the Camel case formatter, and a
published node titled "Test Page" first (the specs rely on them).
