# Chapter 4: Displaying Content through Views

Code for the Views recipes, tested on Drupal 12.0.0-beta2 (PHP 8.5).

| Folder | Provides | Config |
|---|---|---|
| `recipe1/mymodule` | Blog page (`/blog`), Responsive Grid | `views.view.blog` |
| `recipe2/mymodule` | Adds a Recent blogs block (5 items) | `views.view.blog` |
| `recipe3/mymodule` | Adds an exposed Title filter and sorts | `views.view.blog` |
| `recipe4/mymodule` | My Content tab with a contextual filter (`/user/%user/content`) | `views.view.my_content` |
| `recipe5/mymodule` | Notes only; the recipe edits core's Files view in the UI | - |
| `recipe6/mymodule` | Entity reference selection view | `views.view.my_content_reference_view` |

Recipes 1-3 each ship `views.view.blog`, so install only one of them at a
time (they are cumulative snapshots, not add-ons).

## Prerequisites for Drupal 12

The Standard profile in Drupal 12 no longer creates the Article content type,
the Tags vocabulary and field, or a Body field. The Blog views filter on
`node.type.article`, so the module will not install without it. Create the
prerequisites first:

```
vendor/bin/dr recipe core/recipes/tags_taxonomy
drush php:script chp04/setup/setup-article.php
```

With Drush 14 as above, or without Drush: `php chp04/setup/setup-article.php`
from the project root. `setup/setup-article.php` creates the Article type,
Body and Tags fields, their form and view displays, and six sample articles.

## Installing a recipe module

Copy `recipeN/mymodule` to `web/modules/custom/mymodule` and run
`drush en mymodule -y` (Drush 14).

## Test results (12.0.0-beta2)

Recipes 1, 2, 3, 4 and 6 install cleanly and every display builds and executes
with no validation errors. `/blog` returns 200 and lists the articles, the
block display returns 5 rows, the exposed title filter works
(`/blog?title=article+3`), and `/user/1/content` renders. The Files view
(recipe 5) exists at `/admin/content/files`.
