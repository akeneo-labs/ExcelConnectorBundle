<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;

class ContentCacheLoaderSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('Pim\Bundle\ExcelConnectorBundle\Excel\Reader\StubContentCache');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Excel\Reader\ContentCacheLoader');
    }

    public function it_loads_content_cache()
    {
        $this->load('path')->getPath()->shouldReturn('temp_path');
    }
}

class StubContentCache
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
