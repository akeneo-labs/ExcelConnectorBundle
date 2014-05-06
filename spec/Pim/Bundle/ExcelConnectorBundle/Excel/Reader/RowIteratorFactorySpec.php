<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\SharedStrings;

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

    public function it_creates_row_iterators(SharedStrings $sharedStrings)
    {
        $iterator = $this->create($sharedStrings);
        $iterator->getPath()->shouldReturn('path');
        $iterator->getSharedStrings()->shouldReturn($sharedStrings);
    }
}

class StubRowIterator
{
    protected $sharedStrings;
    protected $path;
    public function __construct($sharedStrings, $path)
    {
        $this->sharedStrings = $sharedStrings;
        $this->path = $path;
    }
    public function getPath()
    {
        return $this->path;
    }
    public function getSharedStrings()
    {
        return $this->sharedStrings;
    }
}
