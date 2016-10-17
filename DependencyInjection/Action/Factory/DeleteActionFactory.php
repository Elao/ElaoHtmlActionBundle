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
 * Delete action factory
 */
class DeleteActionFactory extends FormActionFactory
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
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return 'html_delete';
    }

    /**
     * {@inheritdoc}
     */
    public function getServiceId()
    {
        return 'elao_html_action.action.delete';
    }

    /**
     * {@inheritdoc}
     */
    public function getFormType() {
        return 'Elao\Bundle\HtmlActionBundle\Form\Type\DeleteType';
    }

    /**
     * {@inheritdoc}
     */
    protected function getRoutePattern()
    {
        return '/%-names-%/{id}/delete';
    }

    /**
     * Get redirection
     *
     * @return string
     */
    protected function getRedirection()
    {
        return 'list';
    }
}
