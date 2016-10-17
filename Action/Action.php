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

use Elao\Bundle\AdminBundle\Behaviour\ActionInterface;
use Elao\Bundle\AdminBundle\Behaviour\RepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Abstract action
 */
abstract class Action implements ActionInterface
{
    /**
     * Template engine
     *
     * @var EngineInterface $templating
     */
    protected $templating;

    /**
     * Repository
     *
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * Action config parameters
     *
     * @var array
     */
    protected $parameters;

    /**
     * Constructor
     *
     * @param EngineInterface $templating
     * @param RepositoryInterface $repository
     * @param array $parameters
     */
    public function __construct(
        EngineInterface $templating,
        RepositoryInterface $repository,
        array $parameters = []
    ) {
        $this->templating = $templating;
        $this->repository = $repository;
        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function getResponse(Request $request);

    /**
     * Create response
     *
     * @param array $parameters
     *
     * @return Response
     */
    protected function createResponse(array $parameters = [])
    {
        return new Response(
            $this->templating->render($this->parameters['view'], $parameters)
        );
    }
}
