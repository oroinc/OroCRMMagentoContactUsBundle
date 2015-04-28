UPGRADE FROM 1.6 to 1.7
=======================

### Form rendering customization BC break
- Migrated the embedded form templates to the new layout update mechanism introduced by the **OroLayoutBundle**.
Existing customizations of the embedded form layout by overriding the twig template in `app/Resources` will no longer work.
The twig template no longer holds the markup for the whole form but rather the markup for separate blocks defined by the layout engine.
