<?php

/*
 * This file is part of the ElaoHtmlActionBundle.
 *
 * (c) 2016 Elao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\HtmlActionBundle\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\Form;

/**
 * The default action for delete pages
 */
class DeleteAction extends AbstractFormAction
{
    /**
     * {@inheritdoc}
     */
    protected function getModel(Request $request)
    {
        if (!$model = $this->repository->findOneBy($request->get('_route_params'))) {
            throw new NotFoundHttpException();
        }

        return $model;
    }

    /**
     * Persist model from form
     *
     * @param Form $form
     */
    protected function onFormValid(Form $form)
    {
        $this->repository->delete($form->getData());
    }
}
