<?php

/*
 * This file is part of the XhProf Grapher package
 *
 * (c) Charles Sarrazin <charles@sarraz.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace XhProf\Graph\Loader\LoadingStrategy;

use XhProf\Trace;

interface LoadingStrategyInterface
{
    /**
     * @param Trace $trace A trace
     *
     * @return Trace $trace
     */
    public function load(Trace $trace);
}
