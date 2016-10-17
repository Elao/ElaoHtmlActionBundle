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

use Elao\Bundle\HtmlActionBundle\Behaviour\FilterSetInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * The default action for list pages
 */
class ListAction extends Action
{
    /**
     * Form factory
     *
     * @var FormFactoryInterface $formFactory
     */
    protected $formFactory;

    /**
     * Paginator
     *
     * @var Knp\Component\Pager\PaginatorInterface $paginator
     */
    protected $paginator;

    /**
     * Set paginator
     *
     * @param Paginator $paginator
     */
    public function setPaginator(\Knp\Component\Pager\Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * Set form factory
     *
     * @param FormFactoryInterface $formFactory
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse(Request $request)
    {
        if ($filterForm = $this->createFilterForm()) {
            $filterForm->handleRequest($request);
        }

        $filters = $this->getFilters($filterForm);
        $models = $this->getModels($request, $filters);

        return $this->createResponse(
            $this->getViewParameters($request, $models, $filterForm)
        );
    }

    /**
     * Create filter form
     *
     * @return Form
     */
    protected function createFilterForm()
    {
        if (!$this->parameters['filters']['enabled']) {
            return null;
        }

        $data = $this->getFormData($this->parameters['filters']['data']);

        return $this->formFactory
            ->create($this->parameters['filters']['form'], $data)
            ->add('reset', 'reset')
            ->add('submit', 'submit');
    }

    /**
     * Get form data
     *
     * @param null|string $data
     *
     * @return array
     */
    protected function getFormData($data = null)
    {
        if (!$data) {
            return [];
        }

        if (!class_exists($data)) {
            throw new \Exception(sprintf('Class "%s" does not exist.', $data));
        }

        if (!in_array(FilterSetInterface::class, class_implements($data))) {
            throw new \Exception(sprintf('Class "%s" must implement FilterSetInterface.', $data));
        }

        return new $data;
    }

    /**
     * Get filters
     *
     * @param Form $form
     *
     * @return array
     */
    protected function getFilters(Form $form = null)
    {
        if (!$form) {
            return [];
        }

        $data = $form->getData();

        if (is_array($data)) {
            return array_filter($data, function ($value) {
                return $value !== null;
            });
        }

        if ($data instanceof FilterSetInterface) {
            return $data->getFilters();
        }

        throw new \Exception(sprintf('Unknown data type for form "%s".', $form->getName()));
    }

    /**
     * Get models
     *
     * @param Request $request
     * @param array $filters
     *
     * @return PaginationInterface|array
     */
    public function getModels(Request $request, array $filters = [])
    {
        if (!$this->parameters['pagination']['enabled']) {
            return $this->repository->findBy($filters);
        }

        $page = $request->query->get('page', 1);
        $perPage = $this->parameters['pagination']['per_page'];
        $paginable = $this->repository->paginate($filters);

        return $this->paginator->paginate($target, $page, $perPage);
    }

    /**
     * Get view parameters
     *
     * @param Request $request
     * @param array|PaginationInterface $models
     * @param Form $filterForm
     *
     * @return array
     */
    protected function getViewParameters(Request $request, $models, Form $filterForm = null)
    {
        $parameters = [$this->parameters['view_parameter'] => $models];

        if ($filterForm) {
            $parameters['filters'] = $filterForm->createView();
        }

        return $parameters;
    }
}
