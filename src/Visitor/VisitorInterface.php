<?php

/*
 * This file is part of the XhProf Grapher package
 *
 * (c) Charles Sarrazin <charles@sarraz.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace XhProf\Graph\Visitor;

use XhProf\Graph\Edge;
use XhProf\Graph\Graph;
use XhProf\Graph\Vertex;

interface VisitorInterface
{
    /**
     * @param Graph $graph
     *
     * @return mixed
     */
    public function visitGraph(Graph $graph);

    /**
     * @param Edge $edge
     *
     * @return mixed
     */
    public function visitEdge(Edge $edge);

    /**
     * @param Vertex $vertex
     *
     * @return mixed
     */
    public function visitVertex(Vertex $vertex);
}
