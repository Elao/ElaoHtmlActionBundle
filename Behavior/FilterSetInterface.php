<?php

/*
 * This file is part of the ElaoHtmlActionBundle.
 *
 * (c) 2014 Elao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\HtmlActionBundle\Behavior;

/**
 * Filter set interface
 */
interface FilterSetInterface
{
    /**
     * Returns an array of filters for the model manager
     *
     * @return array
     */
    public function getFilters();
}