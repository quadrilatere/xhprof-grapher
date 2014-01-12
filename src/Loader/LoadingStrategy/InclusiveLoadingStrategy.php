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

use XhProf\Graph\Graph;
use XhProf\Graph\Vertex;
use XhProf\Trace;

class InclusiveLoadingStrategy implements LoadingStrategyInterface
{
    public function load(Trace $trace)
    {
        $graph = new Graph();

        foreach ($trace->getData() as $vertices => $weights) {
            if (!$pos = strpos($vertices, '==>')) {
                $fromName = Graph::ROOT;
                $toName = $vertices;
            } else {
                $fromName = substr($vertices, 0, $pos);
                $toName = substr($vertices, $pos + 3);
            }

            $from = $this->findOrCreateVertex($graph, $fromName);
            $to = $this->findOrCreateVertex($graph, $toName);

            $from->connect($to, $weights);
        }

        return $graph;
    }

    private function findOrCreateVertex(Graph $graph, $name)
    {
        if (!$vertex = $graph->getVertex($name)) {
            $vertex = new Vertex($name, $graph);
            $graph->addVertex($vertex);
        }

        return $vertex;
    }
}
