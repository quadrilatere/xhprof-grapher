<?php

/*
 * This file is part of the XhProf Grapher package
 *
 * (c) Charles Sarrazin <charles@sarraz.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace XhProf\Graph\Loader;

use XhProf\Graph\Graph;
use XhProf\Trace;

class GraphLoader
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
            $vertex = $graph->createVertex($name);
        }

        return $vertex;
    }
}
