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

use Elao\Bundle\AdminBundle\Behaviour\NotifierInterface;
use Elao\Bundle\AdminBundle\Behaviour\RepositoryInterface;
use Elao\Bundle\AdminBundle\Behaviour\RouteResolverInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * The default action for create and update pages
 */
abstract class AbstractFormAction extends AbstractAction
{
    /**
     * Form factory
     *
     * @var FormFactoryInterface $formFactory
     */
    protected $formFactory;

    /**
     * Notifier
     *
     * @var NotifierInterface $notifier
     */
    protected $notifier;

    /**
     * Inject dependencies
     *
     * @param RepositoryInterface $repository
     * @param EngineInterface $templating
     * @param FormFactoryInterface $formFactory
     * @param NotifierInterface $notifier
     * @param RouteResolverInterface $routes
     * @param array $parameters
     */
    public function __construct(
        RepositoryInterface $repository,
        EngineInterface $templating,
        FormFactoryInterface $formFactory,
        NotifierInterface $notifier,
        RouteResolverInterface $routes,
        array $parameters
    ) {
        parent::__construct($repository, $templating, $parameters);

        $this->formFactory = $formFactory;
        $this->notifier = $notifier;
        $this->routes = $routes;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse(Request $request)
    {
        $model = $this->getModel($request);
        $form = $this->createForm($model);

        if ($this->handleForm($request, $form)) {
            if ($form->isValid()) {
                $this->onFormValid($form);

                return $this->createSuccessResponse($request, $form);
            } else {
                $this->onFormInvalid($form);
            }
        }

        return $this->createResponse(
            $this->getViewParameters($request, $form)
        );
    }

    /**
     * Get model
     *
     * @param Request $request
     *
     * @return mixed
     */
    abstract protected function getModel(Request $request);

    /**
     * Create form
     *
     * @param mixed $model
     *
     * @return Form
     */
    protected function createForm($model)
    {
        return $this->formFactory
            ->create($this->parameters['form'], $model)
            ->add('submit', SubmitType::class)
        ;
    }

    /**
     * Handle form
     *
     * @param Request $request
     * @param Form $form
     *
     * @return Response|null
     */
    protected function handleForm(Request $request, Form $form)
    {
        return $form->handleRequest($request)->isSubmitted();
    }

    /**
     * On form valid
     *
     * @param Form $form
     */
    protected function onFormValid(Form $form)
    {
        $this->repository->persist($form->getData());
        $this->notifier->notifySuccess($this->getNotifyMessage($form, 'success'));
    }

    /**
     * On form invalid
     *
     * @param Form $form
     */
    protected function onFormInvalid(Form $form)
    {
        $this->notifier->notifyError($this->getNotifyMessage($form, 'error'));
    }

    /**
     * Create success response
     *
     * @param Request $request
     * @param Form $form
     *
     * @return Response
     */
    protected function createSuccessResponse(Request $request, Form $form)
    {
        return new RedirectResponse(
            $this->getSuccessUrl($request, $form->getData())
        );
    }

    /**
     * Get success url for given model
     *
     * @param Request $request
     * @param mixed $data
     *
     * @return string
     */
    protected function getSuccessUrl(Request $request, $data)
    {
        $redirection = $this->parameters['redirection'];

        return $this->routes->getUrl(
            $redirection['name'],
            $redirection['alias'],
            [],
            [
                'request' => $request,
                'data' => $data,
            ]
        );
    }

    /**
     * Get view parameters
     *
     * @param Request $request
     * @param Form $form
     *
     * @return array
     */
    protected function getViewParameters(Request $request, Form $form)
    {
        return ['form' => $form->createView()];
    }

    /**
     * Get message for the given event
     *
     * @param Form $form
     * @param string $event Event: 'success', 'error', 'warning', 'notice'
     *
     * @return string
     */
    protected function getNotifyMessage(Form $form, $event)
    {
        return sprintf(
            'elao_admin.notify.%s.%s.%s',
            $this->parameters['alias'],
            $this->parameters['name'],
            $event
        );
    }
}
