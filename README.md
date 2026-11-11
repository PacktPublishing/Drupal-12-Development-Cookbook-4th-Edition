# Drupal-12-Development-Cookbook-4th-Edition
Drupal 12 Development Cookbook 4th Edition by Packt Publishing

## Chapter 9 -- Creating Forms with the Form API (`chp09/`)

Each `recipeN/mymodule` folder is the state of the `mymodule` module at the end of recipe N. Copy one into `web/modules/custom/` and enable it with Drush 14 (`ddev drush en mymodule`, then `ddev drush cr`). Tested against Drupal 12.0.0-beta2 and PHP 8.5.

| Recipe | Routes |
|--------|--------|
| 1-2 | `/admin/config/company` |
| 3 | adds `/conditional-form` |
| 4 | adds `/counter-form` |
| 5 | adds the OOP `#[Hook]` alter of `/admin/config/system/site-information` |
