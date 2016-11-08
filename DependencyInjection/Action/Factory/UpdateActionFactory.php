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
 * Update action factory
 */
class UpdateActionFactory extends FormActionFactory
{
    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return 'html_update';
    }

    /**
     * {@inheritdoc}
     */
    public function getServiceId()
    {
        return 'elao_html_action.action.update';
    }

    /**
     * {@inheritdoc}
     */
    protected function getRoutePattern()
    {
        return '/%-names-%/{id}/edit';
    }

    /**
     * Get redirection
     *
     * @return string
     */
    protected function getRedirection()
    {
        return 'update';
    }
}
