<?php

namespace XhProf\Graph\Formatter;

use XhProf\Graph\Edge;
use XhProf\Graph\Vertex;

class GraphvizFormatter
{
    private $metricsFormatter;
    private $criticalPath;

    public function __construct(array $criticalPath = array())
    {
        $this->metricsFormatter = new MetricsFormatter();
        $this->criticalPath = $criticalPath;
    }

    public function formatVertex(Vertex $vertex)
    {
        $output = <<<EOT
"%s" [shape=none, label=<
    <table border="0" cellspacing="0" cellborder="1" cellpadding="5" color="%s" bgcolor="%s">
        <tr>
            <td colspan="2" align="left">%s</td>
        </tr>
        <tr>
            <td align="left">ct</td>
            <td align="left">%s</td>
        </tr>
        <tr>
            <td align="left">wt</td>
            <td align="left">%s</td>
        </tr>
        <tr>
            <td align="left">cpu</td>
            <td align="left">%s</td>
        </tr>
        <tr>
            <td align="left">mu</td>
            <td align="left">%s</td>
        </tr>
        <tr>
            <td align="left">pmu</td>
            <td align="left">%s</td>
        </tr>
    </table>
>];
EOT;

        $color = 'black';
        $background = 'white';

        if (in_array($vertex, $this->criticalPath['vertices'])) {
            $color = 'red';
            $background = 'orange';

            foreach ($vertex->getEdges() as $edge) {
                if ($edge->getFrom() === $vertex) {
                    $background = 'yellow';
                }
            }
        }

        return sprintf(
            $output,
            $vertex->getName(),
            $color,
            $background,
            $vertex->getName(),
            $vertex->computeWeight(Edge::CALL_COUNT),
            $this->metricsFormatter->formatTime($vertex->computeWeight(Edge::EXECUTION_TIME)),
            $this->metricsFormatter->formatTime($vertex->computeWeight(Edge::CPU_USAGE)),
            $this->metricsFormatter->formatBytes($vertex->computeWeight(Edge::MEMORY_USAGE)),
            $this->metricsFormatter->formatBytes($vertex->computeWeight(Edge::PEAK_MEMORY_USAGE))
        );
    }

    public function formatEdge(Edge $edge)
    {
        $callCount = $edge->getWeight(Edge::CALL_COUNT);

        $color = 'grey';
        $width = 1;

        if (in_array($edge, $this->criticalPath['edges'])) {
            $color = 'red';
            $width = 5;
        }

        return sprintf(
            '"%s" -> "%s" [color=%s, label="%s", penwidth=%d];',
            $edge->getFrom()->getName(),
            $edge->getTo()->getName(),
            $color,
            $callCount . ' call' . ($callCount > 1 ? 's' : ''),
            $width
        );
    }
}
