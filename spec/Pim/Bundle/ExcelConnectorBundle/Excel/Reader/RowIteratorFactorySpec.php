<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\ContentCache;

class RowIteratorFactorySpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader\StubRowIterator');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Excel\Reader\RowIteratorFactory');
    }

    public function it_creates_row_iterators(ContentCache $contentCache)
    {
        $iterator = $this->create($contentCache);
        $iterator->getPath()->shouldReturn('path');
        $iterator->getContentCache()->shouldReturn($contentCache);
    }
}

class StubRowIterator
{
    protected $contentCache;
    protected $path;
    public function __construct($contentCache, $path)
    {
        $this->contentCache = $contentCache;
        $this->path = $path;
    }
    public function getPath()
    {
        return $this->path;
    }
    public function getContentCache()
    {
        return $this->contentCache;
    }
}
