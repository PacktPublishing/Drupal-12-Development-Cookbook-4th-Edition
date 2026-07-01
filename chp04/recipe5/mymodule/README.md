# Recipe 5: Adding related data in a view with relationships

This recipe modifies Drupal core's **Files** view (`views.view.files`) to
add a User relationship and expose the uploader's username. Because the
Files view is provided by core, the changes are applied to an existing
configuration rather than shipped as a new install YAML.

## What the recipe adds

- A **User who uploaded** relationship, joining files to the users table
- A **Name** field from the User entity, rendered next to each file

## How to apply

Follow the step-by-step instructions in Chapter 4 (Recipe 5) of the
_Drupal 12 Development Cookbook_. The recipe walks through:

1. Editing the Files view at Administration | Structure | Views
2. Expanding the **Advanced** section and adding a Relationship
3. Selecting the **User who uploaded** relationship
4. Adding the **Name** field from the User category
5. Saving the view and verifying the new column at `/admin/content/files`

## Why no install YAML?

Shipping a `views.view.files.yml` file would overwrite the entire core
Files view on module install, which is destructive for anyone who has
already customized the view or is running the module alongside other
customizations. Following the chapter steps in the UI is safer.
