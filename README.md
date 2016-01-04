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
        MyEntity:
            options:
                model: AppBundle\Entity\MyEntity
            actions:
                list:
                    options:
                        parameters:
                            # Explicit path is optional
                            view: AppBundle:MyEntity:list.html.twig
                            # Pagination is optional
                            pagination:
                                per_page: 10
                            # Filters are optional
                            filters:
                                form_type: AppBundle\Form\FiltersMyEntityType
                                data: ~
                create:
                    options:
                        parameters:
                            # Explicit path is optional
                            view: AppBundle:MyEntity:update.html.twig
                            form_type: AppBundle\Form\MyEntityType
                            # Explicit redirection is optional. Default for this action is 'update'
                            redirection: 'list'
                read:
                    options:
                        parameters:
                            # Explicit path is optional
                            view: AppBundle:MyEntity:read.html.twig
                update:
                    options:
                        parameters:
                            # Explicit path is optional
                            view: AppBundle:MyEntity:update.html.twig
                            form_type: AppBundle\Form\MyEntityType
                            # Explicit redirection is optional. Default for this action is 'update'
                            redirection: 'list'
                delete:
                    options:
                        parameters:
                            # Explicit path is optional
                            view: AppBundle:MyEntity:delete.html.twig
                            form_type: AppBundle\Form\DeleteMyEntityType
                            # Explicit redirection is optional. Default for this action is 'list'
                            redirection: 'list'
```

##Views
Please note that the views are not provided with the bundle. You have to create them to display the different forms.

Default path for the view is `app/Resources/%administration_name%/%action_name%.html.twig`. You can override this by setting an explicit view in action's options.

Pagination is optional, and if enabled (configuration exists) is rendered with [KnpPaginatorBundle](https://github.com/KnpLabs/KnpPaginatorBundle)
