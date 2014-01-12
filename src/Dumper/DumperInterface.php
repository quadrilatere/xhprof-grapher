<?php

/*
 * This file is part of the XhProf Grapher package
 *
 * (c) Charles Sarrazin <charles@sarraz.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace XhProf\Graph\Dumper;

use XhProf\Graph\Graph;

interface DumperInterface
{
    /**
     * @param Graph $graph
     *
     * @return mixed
     * @api
     */
    public function dump(Graph $graph);
}
