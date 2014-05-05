<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\Archive;

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

    public function it_loads_content_cache(Archive $archive)
    {
        $archive->extract('archive_path')->willReturn('temp_path');
        $this->load($archive)->shouldReturn('temp_path');
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
