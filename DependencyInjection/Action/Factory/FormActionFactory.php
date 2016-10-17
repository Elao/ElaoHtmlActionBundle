<?php

/*
 * This file is part of the ElaoHtmlActionBundle.
 *
 * (c) 2014 Elao <contact@elao.com>
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
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('redirection')
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
        return '::form.html.twig';
    }

    /**
     * Get rediration action alias (list, new, update, ...)
     *
     * @return string
     */
    abstract protected function getRedirection();
}
