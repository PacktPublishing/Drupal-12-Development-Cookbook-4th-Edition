# Chapter 17 — Creating Drupal Recipes

The artifacts for this chapter are **Drupal Recipes** (a `recipe.yml` plus a
`config/` directory), not modules — so each folder here is a ready-to-apply
recipe rather than the `mymodule/` layout used by the other chapters.

## Layout

| Folder | Recipe | Chapter recipe |
| ------ | ------ | -------------- |
| `recipe2/my_blog` | Blog content type, Tags field, listing view, permissions | Creating your first Drupal Recipe |
| `recipe3/my_events` | Events content type with a date field | Composing Recipes together |
| `recipe3/my_seo` | Installs a curated set of SEO modules | Composing Recipes together |
| `recipe3/company_website` | Composes `my_blog` + `my_events` + `my_seo` | Composing Recipes together |
| `recipe4/my_site_setup` | Uses the `input` key to prompt for site name and email | Distributing and applying Recipes with Composer |
| `recipe5/my_portfolio` | Portfolio content type plus `createIfNotExists` / `simpleConfigUpdate` config actions | Converting existing configuration to a Recipe |

## Applying a recipe

Copy a recipe folder into your site's `web/recipes/` directory and apply it with
Drush 14. The recipe path is resolved relative to Drupal's docroot (the `web`
directory), which is where `ddev drush` runs:

```bash
cp -r recipe2/my_blog /path/to/site/web/recipes/
ddev drush recipe recipes/my_blog
ddev drush cr
```

Core's own CLI is an alternative when Drush is unavailable
(`recipe` is an alias of `recipe:apply`):

```bash
ddev exec vendor/bin/dr recipe recipes/my_blog
```

`recipe3/company_website` composes the other recipes, so `my_blog`, `my_events`,
and `my_seo` must sit alongside it in `web/recipes/`. Apply a composed recipe on
a site that does not already have the sub-recipes' configuration, or clear that
configuration first — re-applying a recipe whose `config/` objects already exist
stops with an *exists already and does not match* error.

`recipe4/my_site_setup` takes inputs. Pass them on the command line as
`--input=my_site_setup.site_name='Acme Co' --input=my_site_setup.site_mail=hi@acme.test`
(`vendor/bin/dr recipe`) or answer the prompts.

## Drupal 12 notes

- Standard no longer ships a Body field, the Toolbar module, or the Article and
  Basic page recipes. These recipes do not depend on any of them, but blog,
  event, and portfolio posts have no body text unless you add a Body field.
- `company_website` no longer installs `admin_toolbar`/`admin_toolbar_search` or
  grants `access toolbar` (the permission was removed with the Toolbar module;
  applying it only logs a "Non-existent permission(s)" error).
- `recipe5/my_portfolio` ships the category and image fields and the form and
  view displays that the chapter describes (without a Body field).
- `recipe3/my_seo` (and therefore `company_website`) needs `pathauto`,
  `metatag`, `redirect`, and `simple_sitemap`. At the time of the Drupal
  12.0.0-beta2 test none of them had a release that installs on Drupal 12, so
  these two recipes fail at apply time with *"... is not a known module or
  theme"* until those releases exist.
- `config` actions on config entities (for example `views.view.*`) must use
  `setProperties`; `simpleConfigUpdate` is only for simple configuration such as
  `system.site`.

All other recipes were applied and verified on Drupal 12.0.0-beta2 (core
`vendor/bin/dr recipe`; Drush 14 is the book's assumed version).
