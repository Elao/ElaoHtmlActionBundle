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

use Elao\Bundle\AdminBundle\DependencyInjection\Action\Factory\ActionFactory as ElaoActionFactory;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Action Factory
 */
abstract class ActionFactory extends ElaoActionFactory
{
    /**
     * {@inheritdoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        parent::addConfiguration($node);

        $node
            ->children()
                ->scalarNode('repository')
                    ->defaultValue('repository.%name%')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('view')
                    ->defaultValue($this->getView())
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('view_parameter')
                    ->defaultValue($this->getViewParameter())
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ;
    }

    public function configureAction(Definition $definition, array $config)
    {
        $definition->addArgument(new Reference($config['repository']));

        parent::configureAction($definition, $config);
    }

    /**
     * Get default view
     *
     * @return string
     */
    protected function getView()
    {
        return ':%name%:%alias%.html.twig';
    }

    /**
     * Get default view parameter name for model variable
     *
     * @return string
     */
    protected function getViewParameter()
    {
        return '%name%';
    }

    /**
     * {@inheritdoc}
     */
    protected function getRouteName()
    {
        return '%name%_%alias%';
    }
}
