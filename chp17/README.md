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
Drush. The recipe path is resolved relative to Drupal's docroot (the `web`
directory), which is where `ddev drush` runs:

```bash
cp -r recipe2/my_blog /path/to/site/web/recipes/
ddev drush recipe recipes/my_blog
```

`recipe3/company_website` composes the other recipes, so `my_blog`, `my_events`,
and `my_seo` must sit alongside it in `web/recipes/`. Apply a composed recipe on
a site that does not already have the sub-recipes' configuration, or clear that
configuration first — re-applying a recipe whose `config/` objects already exist
stops with an *exists already and does not match* error.

`recipe3/my_seo` and `recipe4`/`recipe5` install contributed modules
(`pathauto`, `metatag`, `redirect`, `simple_sitemap`, `admin_toolbar`, and
`admin_toolbar_search`); run `ddev composer require` for those before applying.

All recipes were verified against Drupal 12 (tested on the 11.3.x line with
Drush 13).
