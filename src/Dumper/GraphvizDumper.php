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

use XhProf\Graph\Extractor\CriticalPathExtractor;
use XhProf\Graph\Formatter\GraphvizFormatter;
use XhProf\Graph\Graph;
use XhProf\Graph\Visitor\GraphvizVisitor;

class GraphvizDumper implements DumperInterface
{
    private $executor;

    /**
     * @param string $format
     */
    public function __construct($format = 'png')
    {
        $this->executor = new DotScriptExecutor($format);
    }

    /**
     * {@inheritDoc}
     */
    public function dump(Graph $graph, $callGraph = true)
    {
        $formatter = null;

        if ($callGraph) {
            $extractor = new CriticalPathExtractor();
            $formatter = new GraphvizFormatter($extractor->extract($graph));
        }

        $visitor = new GraphvizVisitor($formatter);
        $visitor->visitGraph($graph);
        return $this->executor->execute($visitor->getOutput());
    }
}
