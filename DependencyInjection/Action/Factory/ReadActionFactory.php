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

/**
 * Read action factory
 */
class ReadActionFactory extends ActionFactory
{
    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return 'html_read';
    }

    /**
     * {@inheritdoc}
     */
    public function getServiceId()
    {
        return 'elao_html_action.action.read';
    }

    /**
     * {@inheritdoc}
     */
    protected function getRoutePattern()
    {
        return '/%-names-%/{id}';
    }

    /**
     * {@inheritdoc}
     */
    protected function getRouteMethods()
    {
        return ['GET'];
    }
}
