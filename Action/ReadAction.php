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
 * The default action for read pages
 */
class ReadAction extends AbstractAction
{
    /**
     * {@inheritdoc}
     */
    public function getResponse(Request $request)
    {
        $model = $this->getModel($request);

        return $this->createResponse(
            $this->getViewParameters($request, $model)
        );
    }

    /**
     * Get view parameters
     *
     * @param Request $request
     * @param mixed $model
     *
     * @return array
     */
    protected function getViewParameters(Request $request, $model)
    {
        return [$this->parameters['view_parameter'] => $model];
    }

    /**
     * Get model from request
     *
     * @param Request $request
     *
     * @return mixed
     */
    protected function getModel(Request $request)
    {
        if (!$model = $this->repository->findOneBy($request->get('_route_params'))) {
            throw new NotFoundHttpException();
        }

        return $model;
    }
}
