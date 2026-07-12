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
    auth.setup.ts                       # reusable authenticated-state setup (There's more)
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

All PHPUnit suites and Playwright specs were verified against Drupal 12 (tested
on the 11.3.x line with PHPUnit 11.5).
