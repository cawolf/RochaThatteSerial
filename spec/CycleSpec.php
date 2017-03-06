<?php

namespace spec\Cawolf\RochaThatte;

use Cawolf\RochaThatte\Cycle;
use Fhaculty\Graph\Edge\Directed;
use Fhaculty\Graph\Graph;
use PhpSpec\ObjectBehavior;

class CycleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Cycle::class);
    }

    function it_detects_cycles_in_empty_graphs(Graph $graph)
    {
        $this->detect($graph)->shouldHaveCount(0);
    }

    function it_detects_cycles_in_simple_graphs()
    {
        $graph = new Graph();
        $graph->createVertices(2);
        $graph->addEdge(new Directed($graph->getVertex(0), $graph->getVertex(1)));
        $graph->addEdge(new Directed($graph->getVertex(1), $graph->getVertex(0)));
        $this->detect($graph)->shouldBeEqualTo([[0, 1]]);
    }

    function it_detects_cycles_in_normal_graphs()
    {
        $graph = new Graph();
        $graph->createVertices(5);
        $graph->addEdge(new Directed($graph->getVertex(0), $graph->getVertex(1)));
        $graph->addEdge(new Directed($graph->getVertex(1), $graph->getVertex(2)));
        $graph->addEdge(new Directed($graph->getVertex(2), $graph->getVertex(3)));
        $graph->addEdge(new Directed($graph->getVertex(3), $graph->getVertex(1)));
        $graph->addEdge(new Directed($graph->getVertex(2), $graph->getVertex(4)));
        $this->detect($graph)->shouldBeEqualTo([[1, 2, 3]]);
    }

    function it_detects_cycles_in_complex_graphs()
    {
        $graph = new Graph();
        $graph->createVertices(16);
        $graph->addEdge(new Directed($graph->getVertex(0), $graph->getVertex(4)));
        $graph->addEdge(new Directed($graph->getVertex(1), $graph->getVertex(5)));
        $graph->addEdge(new Directed($graph->getVertex(2), $graph->getVertex(7)));
        $graph->addEdge(new Directed($graph->getVertex(3), $graph->getVertex(7)));
        $graph->addEdge(new Directed($graph->getVertex(4), $graph->getVertex(8)));
        $graph->addEdge(new Directed($graph->getVertex(5), $graph->getVertex(8)));
        $graph->addEdge(new Directed($graph->getVertex(6), $graph->getVertex(8)));
        $graph->addEdge(new Directed($graph->getVertex(7), $graph->getVertex(9)));
        $graph->addEdge(new Directed($graph->getVertex(8), $graph->getVertex(10)));
        $graph->addEdge(new Directed($graph->getVertex(9), $graph->getVertex(10)));
        $graph->addEdge(new Directed($graph->getVertex(10), $graph->getVertex(11)));
        $graph->addEdge(new Directed($graph->getVertex(11), $graph->getVertex(13)));
        $graph->addEdge(new Directed($graph->getVertex(12), $graph->getVertex(10)));
        $graph->addEdge(new Directed($graph->getVertex(13), $graph->getVertex(15)));
        $graph->addEdge(new Directed($graph->getVertex(14), $graph->getVertex(12)));
        $graph->addEdge(new Directed($graph->getVertex(15), $graph->getVertex(14)));
        $this->detect($graph)->shouldBeEqualTo([[10, 11, 13, 15, 14, 12]]);
    }
}
