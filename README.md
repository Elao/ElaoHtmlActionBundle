HTML Action Bundle ![](https://img.shields.io/badge/Symfony-3.0-blue.svg)
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
        // ElaoHtmlActionBundle requires ElaoAdminBundle, you'll need to register it too.
        // new Elao\Bundle\ElaoAdminBundle\ElaoAdminBundle(),
        new Elao\Bundle\HtmlActionBundle\ElaoHtmlActionBundle(),
    );
}
```

##Configuration

The HtmlActionBundle provides 5 actions for the AdminBundle:

- **html_list**: a list of models. _e.g. "GET /posts"_
- **html_create**: a creation form and its POST handler.  _e.g. "GET|POST /posts/new"_
- **html_read**: details for a single model. _e.g. "GET /posts/{id}"_
- **html_update**: a modification form for a single model and its POST handler.  _e.g. "GET|POST /posts/{id}/edit"_
- **html_delete**: a deletion form for a single model (ask for user confirmation) and its POST handler.  _e.g. "GET|DELETE /posts/{id}/delete"_

Here's how you define a simple CRUD administration for a "Post" entity.

```yml
elao_admin:
    administrations:
        # Administration, named after the model, will impact urls and route names
        post:
            # The repository service for the Post model (usually DoctrineRepository for model "Post")
            repository: blog.repository.post
            # The list of actions
            actions:
                list:
                    # We're using default values for the list
                    html_list: ~
                create:
                    html_create:
                        # Specify the form type to use to create a Post
                        form: BlogBundle\Form\PostType
                update:
                    html_update:
                        # Specify the form type to use to edit a Post
                        form: BlogBundle\Form\PostType
                read:
                    # We're using default values for the read
                    html_read: ~
                delete:
                    html_delete:
                        # We're adding a security restriction on the delete action
                        security: has_role('ROLE_ADMIN')
```

Don't forget to declare the corresponding repository service:
(extends `elao_admin.repository.doctrine`/`Elao\Bundle\AdminBundle\Service\DoctrineRepository` or use your own implementation of `Elao\Bundle\AdminBundle\Behaviour\RepositoryInterface`)

```yml
# services.yml
blog.repository.post:
    parent: elao_admin.repository.doctrine
    arguments: ['BlogBundle\Entity\Post']
```

### Full configuration

__List__

| Parameter | Description   | Required | Default value |
| --------- | ------------- | -------- | ------------- |
| `view`          | The template to render the page with. | false | `:post:list.html.twig` |
| `view_parameter` | The variable name of the model or list of model in the template. | false | `posts` |

__Create__

| Parameter | Description   | Required | Default value |
| --------- | ------------- | -------- | ------------- |
| `form`           | The form type to use to create the model. | true | |
| `view`           | The template to render the page with. | false | `:post:create.html.twig` |
| `view_parameter` | The variable name of the model or list of model in the template. | false | `post` |
| `redirection`    | The action to redirect the user to when the action has been performed. | false | `list` |

__Read__

| Parameter | Description   | Required | Default value |
| --------- | ------------- | -------- | ------------- |
| `view`           | The template to render the page with. | false | `:post:update.html.twig` |
| `view_parameter` | The variable name of the model or list of model in the template. | false | `post` |

__Update__

| Parameter | Description   | Required | Default value |
| --------- | ------------- | -------- | ------------- |
| `form`           | The form type to use to create the model. | true | |
| `view`           | The template to render the page with. | false | `:post:update.html.twig` |
| `view_parameter` | The variable name of the model or list of model in the template. | false | `post` |
| `redirection`    | The action to redirect the user to when the action has been performed. | false | `list` |

__Delete__

| Parameter | Description   | Required | Default value |
| --------- | ------------- | -------- | ------------- |
| `form`           | The form type to use to create the model. | false | `Elao\Bundle\HtmlActionBundle\Form\Type\DeleteType` |
| `view`           | The template to render the page with. | false | `:post:delete.html.twig` |
| `view_parameter` | The variable name of the model or list of model in the template. | false | `post` |
| `redirection`    | The action to redirect the user to when the action has been performed. | false | `list` |


## Views

Please note that the views are not provided with the bundle. You have to create them to display the different forms.

Default path for the views is `app/Resources/[name]/[alias].html.twig`.
You can override this by setting an explicit view in action's options.

## Doctrine service repositories (optional):

For convenience, you can use AdminBundle's DoctrineRepository as the default doctrine repository.
This way the Doctrine entity manager's `getRepository` method will return the repository service declared for each model.

To activate this feature:

```
# config.yml
elao_admin:
    doctrine_service_repositories: true

doctrine:
    default_repository_class:  Elao\Bundle\AdminBundle\Service\DoctrineRepository
    repository_factory: elao_admin.repository_factory.doctrine
```
