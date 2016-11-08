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
                ->scalarNode('redirection')
                    ->info('The action to redirect the user to when the action has been performed.')
                    ->cannotBeEmpty()
                    ->defaultValue($this->getRedirection())
                ->end()
            ->end()
        ;
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
