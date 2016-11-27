<?php

/*
 * This file is part of the ElaoHtmlActionBundle.
 *
 * (c) 2016 Elao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\HtmlActionBundle\DependencyInjection\Action\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Form action factory
 */
abstract class FormActionFactory extends ActionFactory
{
    /**
     * {@inheritdoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        parent::addConfiguration($node);

        $node
            ->children()
                ->scalarNode('form')
                    ->info('Form class name or service id.')
                    ->defaultValue($this->getFormType())
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('redirection')
                    ->info('The action to redirect the user to when the action has been performed.')
                    ->addDefaultsIfNotSet()
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($value) {
                            return ['name' => '%name%', 'alias' => $value];
                        })
                    ->end()
                    ->children()
                        ->scalarNode('name')
                            ->defaultValue('%name%')
                        ->end()
                        ->scalarNode('alias')
                            ->defaultValue($this->getRedirection())
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * Configure action service
     *
     * @param Definition $definition
     */
    public function configureAction(Definition $definition)
    {
        parent::configureAction($definition);

        $definition->replaceArgument(4, new Reference($this->routeResolver));
    }

    /**
     * {@inheritdoc}
     */
    protected function getRouteMethods()
    {
        return ['GET', 'POST'];
    }

    /**
     * Get default view
     *
     * @return string
     */
    protected function getView()
    {
        return ':%name%:form.html.twig';
    }

    /**
     * Get form type
     *
     * @return null|string
     */
    protected function getFormType()
    {
        return null;
    }

    /**
     * Get rediration action alias (list, new, update, ...)
     *
     * @return string
     */
    abstract protected function getRedirection();
}
