<?php

/*
 * This file is part of the ElaoHtmlActionBundle.
 *
 * (c) 2016 Elao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\HtmlActionBundle\DependencyInjection\Administration\Configurator;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Elao\Bundle\AdminBundle\Behaviour\AdministrationConfiguratorInterface;

/**
 * HTML Action Administration Configurator
 */
class AdministrationConfigurator implements AdministrationConfiguratorInterface
{
    /**
     * Add configuration
     *
     * @param NodeBuilder $node
     */
    public function configure(NodeBuilder $node)
    {
        $node
            ->scalarNode('repository')
                ->info('Must implements Elao\Bundle\AdminBundle\Behaviour\RepositoryInterface')
                ->defaultValue($this->getRepositoryName())
                ->cannotBeEmpty()
            ->end()
            ->scalarNode('route_resolver')
                ->info('Must implements Elao\Bundle\AdminBundle\Behaviour\RouteResolverInterface')
                ->defaultValue('elao_admin.route_resolver')
                ->cannotBeEmpty()
            ->end()
        ;
    }

    /**
     * Get repository name
     *
     * @return string
     */
    protected function getRepositoryName()
    {
        return 'repository.[name]';
    }
}
