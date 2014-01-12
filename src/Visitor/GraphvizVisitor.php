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
use XhProf\Graph\Formatter\GraphvizFormatter;
use XhProf\Graph\Graph;
use XhProf\Graph\Vertex;

class GraphvizVisitor implements VisitorInterface
{
    private $output;
    private $formatter;

    public function __construct(GraphvizFormatter $formatter = null)
    {
        $this->output = array();
        $this->formatter = $formatter ?: new GraphvizFormatter();
    }

    public function getOutput()
    {
        return implode(PHP_EOL, $this->output);
    }

    /**
     * {@inheritDoc}
     */
    public function visitGraph(Graph $graph)
    {
        $this->output[] = 'digraph G {';
        $graph->accept($this);
        $this->output[] = '}';
    }

    /**
     * {@inheritDoc}
     */
    public function visitEdge(Edge $edge)
    {
        if (!$edge->getTo()) {
            return;
        }

        $this->output[] = $this->formatter->formatEdge($edge);
        $edge->accept($this);
    }

    /**
     * {@inheritDoc}
     */
    public function visitVertex(Vertex $vertex)
    {
        $this->output[] = $this->formatter->formatVertex($vertex);
        $vertex->accept($this);
    }
}
