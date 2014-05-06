<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\ValueTransformer;

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

    public function it_creates_row_iterators(ValueTransformer $valueTransformer)
    {
        $iterator = $this->create($valueTransformer, 'path');
        $iterator->getPath()->shouldReturn('path');
        $iterator->getValueTransformer()->shouldReturn($valueTransformer);
    }
}

class StubRowIterator
{
    protected $valueTransformer;
    protected $path;
    public function __construct($valueTransformer, $path)
    {
        $this->valueTransformer = $valueTransformer;
        $this->path = $path;
    }
    public function getPath()
    {
        return $this->path;
    }
    public function getValueTransformer()
    {
        return $this->valueTransformer;
    }
}
