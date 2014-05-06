<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;

class SharedStringsLoaderSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('Pim\Bundle\ExcelConnectorBundle\Excel\Reader\StubSharedStrings');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Excel\Reader\SharedStringsLoader');
    }

    public function it_loads_shared_strings()
    {
        $this->load('path')->getPath()->shouldReturn('temp_path');
    }
}

class StubSharedStrings
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
