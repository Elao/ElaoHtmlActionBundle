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
 * The default action for update pages
 */
class UpdateAction extends FormAction
{
    /**
     * {@inheritdoc}
     */
    protected function getModel(Request $request)
    {
        $model = $this->modelManager->find($request->get('_route_params'));

        if (!$model) {
            throw new NotFoundHttpException;
        }

        return $model;
    }
}
