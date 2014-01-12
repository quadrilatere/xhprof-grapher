<?php

/*
 * This file is part of the XhProf Grapher package
 *
 * (c) Charles Sarrazin <charles@sarraz.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace XhProf\Graph\Extractor;

use XhProf\Graph\Edge;
use XhProf\Graph\Graph;
use XhProf\Graph\Vertex;

class CriticalPathExtractor
{
    private $weight;
    private $edges;
    private $vertices;

    public function __construct($weight = Edge::EXECUTION_TIME)
    {
        $this->weight = $weight;
        $this->edges = array();
        $this->vertices = array();
    }

    public function extract(Graph $graph)
    {
        if (!$vertex = $graph->getVertex('main()')) {
            throw new \LogicException('The graph should at least have a main() node.');
        }

        $this->computePath($vertex);

        return array('edges' => $this->edges, 'vertices' => $this->vertices);
    }

    private function computePath(Vertex $vertex)
    {
        $edges = $vertex->getEdges();
        $max = $edges[0];

        foreach ($edges as $edge) {
            if ($edge->getFrom() === $vertex) {
                if ($max->getWeight($this->weight) < $edge->getWeight($this->weight)) {
                    $max = $edge;
                }
            }
        }

        $this->vertices[] = $vertex;

        if (!in_array($max, $this->edges)) {
            $this->edges[] = $max;
            $this->computePath($max->getTo());
        }
    }
} 