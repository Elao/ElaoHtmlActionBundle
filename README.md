HTML Action Bundle
==================

This bundle provides CRUD + List Actions to be used with [ElaoAdminBundle](https://github.com/Elao/ElaoAdminBundle)

## Installation

Require the bundle in _Composer_:

```bash
$ composer require elao/html-action-bundle
```

Install the bundle in your _AppKernel_:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        //...
        new Elao\Bundle\HtmlActionBundle\ElaoHtmlActionBundle(),
    );
}
```

##Configuration

Here is a configuration sample

```yml
elao_admin:
    administrations:
        post:
            actions:
                list:
                    html_list: ~
                create:
                    html_create:
                        form: BlogBundle\Form\PostType
                update:
                    html_update:
                        form: BlogBundle\Form\PostType
                read:
                    html_read: ~
                delete:
                    html_delete:
                        security: has_role('ROLE_ADMIN')
```

### Default configuration

:%name%:%alias%.html.twig

Repositories

By default, the actions are looking for a

##Views
Please note that the views are not provided with the bundle. You have to create them to display the different forms.

Default path for the view is `app/Resources/%administration_name%/%action_name%.html.twig`.
You can override this by setting an explicit view in action's options.

Pagination is optional, and if enabled (configuration exists) is rendered with [KnpPaginatorBundle](https://github.com/KnpLabs/KnpPaginatorBundle)
