<?php

namespace Cawolf\RochaThatte;

use Fhaculty\Graph\Edge\Directed;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Vertex;

/**
 * Serial implementation of the parallel Rocha-Thatte cycle detection algorithm
 *
 * @see https://en.wikipedia.org/wiki/Rocha-Thatte_cycle_detection_algorithm
 * @package Cawolf\RochaThatte
 */
class Cycle
{
    /** @var Vertex[] $vertex */
    private $activeVertices;
    private $inbound = [];
    private $outbound = [];
    private $cycles = [];

    /**
     * Detects cycles in a given directed graph.
     *
     * The result set will be an array of array of vertex indices found to be a cycle.
     *
     * E.g.: consider the following graph
     *
     *    +-> 1 +---> 2 +---> 3 +---> 4
     *    |                     |
     *    +---------------------+
     *
     * The result for this graph will be
     *    [
     *        [1, 2, 3]
     *    ]
     *
     * @param Graph $graph graph to detect cycles in
     * @return array of array of vertex indices
     */
    public function detect(Graph $graph)
    {
        if ($graph->getVertices()) {
            $this->activeVertices = $graph->getVertices()->getMap();

            // initial messages
            foreach ($this->activeVertices as $vertex) {
                $this->sendToNeighbors([], $vertex);
            }

            while ($this->activeVertices) {
                $this->superStep();
            }
        }

        return $this->cycles;
    }

    /**
     * Execute a super step.
     */
    private function superStep()
    {
        // send the messages
        $this->inbound = $this->outbound;
        $this->outbound = [];

        $deactivating = [];
        foreach ($this->activeVertices as $vertex) {
            if (!isset($this->inbound[$vertex->getId()])) {
                $deactivating[$vertex->getId()] = true;
            } else {
                // handle incoming messages
                foreach ($this->inbound[$vertex->getId()] as $inbound) {
                    if (in_array($vertex->getId(), $inbound)) {
                        // vertex found itself, stop message passing
                        if (min($inbound) == $vertex->getId()) {
                            // report only if it's the vertex with the lowest index
                            $this->cycles[] = $inbound;
                        }
                    } else {
                        $this->sendToNeighbors($inbound, $vertex);
                    }
                }
            }
        }

        // actually deactivate vertices
        $this->activeVertices = array_diff_key($this->activeVertices, $deactivating);
    }

    /**
     * Sends a message plus the vertex id to the vertex's neighbors.
     *
     * @param array $message
     * @param Vertex $vertex
     */
    private function sendToNeighbors(array $message, Vertex $vertex)
    {
        foreach ($vertex->getEdgesOut() as $edgeOut) {
            /** @var Directed $edgeOut */
            $this->outbound[$edgeOut->getVertexEnd()->getId()][] = array_merge($message, [$vertex->getId()]);
        }
    }
}
