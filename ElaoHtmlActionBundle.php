<?php

/*
 * This file is part of the ElaoHtmlActionBundle.
 *
 * (c) 2016 Elao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\HtmlActionBundle;

use Elao\Bundle\HtmlActionBundle\DependencyInjection\Administration\Configurator\AdministrationConfigurator;
use Elao\Bundle\HtmlActionBundle\DependencyInjection\Action\Factory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ElaoHtmlActionBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('elao_admin');
        $extension->addAdministrationConfigurator(new AdministrationConfigurator());
        $extension->addActionFactory(new Factory\ReadActionFactory());
        $extension->addActionFactory(new Factory\CreateActionFactory());
        $extension->addActionFactory(new Factory\UpdateActionFactory());
        $extension->addActionFactory(new Factory\DeleteActionFactory());
        $extension->addActionFactory(new Factory\ListActionFactory());
    }
}
