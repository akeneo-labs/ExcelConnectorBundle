<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RelationshipsLoaderSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader\StubRelationships');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Excel\Reader\RelationshipsLoader');
    }

    function it_loads_relationships()
    {
        $this->load('path')->getPath()->shouldReturn('path');
    }
}

class StubRelationships
{
    protected $path;
    public function __construct($path)
    {
        $this->path = $path;
    }
    public function getPath()
    {
        return $this->path;
    }
}