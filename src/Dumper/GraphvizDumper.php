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
    private $format;

    /**
     * @param string $format
     */
    public function __construct($format = 'png')
    {
        $this->format = $format;
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
        return $this->executeDotScript($visitor->getOutput());
    }

    /**
     * @param string $dotScript
     *
     * @return string
     * @throws DumperException
     */
    private function executeDotScript($dotScript)
    {
        $descriptors = array(
            array('pipe', 'r'),
            array('pipe', 'w'),
            array('pipe', 'w'),
        );

        $process = proc_open(sprintf('dot -T%s', $this->format), $descriptors, $pipes);

        if (false === $process) {
            throw new DumperException('Failed to initiate DOT process.');
        }

        fwrite($pipes[0], $dotScript);
        fclose($pipes[0]);

        $output = stream_get_contents($pipes[1]);
        $error = stream_get_contents($pipes[2]);

        fclose($pipes[1]);
        fclose($pipes[2]);

        proc_close($process);

        if (!empty($error)) {
            throw new DumperException(sprintf('DOT produced an error: %s', trim($error)));
        }

        if (empty($output)) {
            throw new DumperException('DOT did not output anything.');
        }

        return $output;
    }
}
