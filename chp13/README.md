# Chapter 13: Multilingual and Internationalization

Code examples for Chapter 13 of the Drupal 12 Development Cookbook. Tested on Drupal 12.0.0-beta2 (PHP 8.5).

Most of this chapter is configured through the administration UI, so only the recipes that present code have a folder here.

| Folder | Recipe | Contents |
|---|---|---|
| `recipe2/scripts/add_translation.php` | Creating content translations (There's more: programmatically creating translations) | Adds a Spanish translation to a node with `addTranslation()`. |
| `recipe3/my_custom_module` | Providing translations for code strings | `info.yml` with the `interface translation project` and `interface translation server pattern` keys, plus a sample `translations/es.po`. |
| `recipe4/my_config_translation_alter` | Internationalizing date formats (There's more: altering configuration translation info definitions) | OOP `#[Hook('config_translation_info_alter')]` class that swaps in a mapper class, following core's `Drupal\node\Hook\NodeConfigTranslationHooks`. |

## Usage

Copy a module into `web/modules/custom/`, then enable the prerequisites and the module with Drush 14:

```
drush en language locale content_translation config_translation -y
drush en my_config_translation_alter -y
```

To run the node translation script (set `$nid` first, and enable translation for the content type):

```
drush php:script recipe2/scripts/add_translation.php
```

The `.po` file is imported at Administration | Configuration | Regional and Language | User interface translation | Import, with the language set to Spanish.

## Notes

- The Translation Management Tool (TMGMT) recipe has no custom code (only `composer require` and UI steps), and TMGMT has no Drupal 12 release yet, so nothing is included for it.
- The script in `recipe2` writes a `body` field. Drupal 12's Standard profile no longer creates a Body field, so add one to the content type first or the value is ignored.
