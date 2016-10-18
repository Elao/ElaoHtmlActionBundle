<?php

/*
 * This file is part of the ElaoHtmlActionBundle.
 *
 * (c) 2014 Elao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\HtmlActionBundle\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * The default action for create pages
 */
class CreateAction extends AbstractFormAction
{
    /**
     * {@inheritdoc}
     */
    protected function getModel(Request $request)
    {
        return $this->repository->create();
    }
}
