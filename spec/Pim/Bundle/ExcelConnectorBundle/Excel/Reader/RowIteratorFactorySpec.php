<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\ColumnIndexTransformer;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\RowBuilderFactory;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\ValueTransformer;

class RowIteratorFactorySpec extends ObjectBehavior
{
    public function let(RowBuilderFactory $rowBuilderFactory, ColumnIndexTransformer $columnIndexTransformer)
    {
        $this->beConstructedWith(
            $rowBuilderFactory,
            $columnIndexTransformer,
            'spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader\StubRowIterator'
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Excel\Reader\RowIteratorFactory');
    }

    public function it_creates_row_iterators(
        RowBuilderFactory $rowBuilderFactory,
        ColumnIndexTransformer $columnIndexTransformer,
        ValueTransformer $valueTransformer
    ) {
        $iterator = $this->create($valueTransformer, 'path');
        $iterator->getPath()->shouldReturn('path');
        $iterator->getValueTransformer()->shouldReturn($valueTransformer);
        $iterator->getRowBuilderFactory()->shouldReturn($rowBuilderFactory);
        $iterator->getColumnIndexTransformer()->shouldReturn($columnIndexTransformer);
    }
}

class StubRowIterator
{
    protected $rowBuilderFactory;
    protected $columnIndexTransformer;
    protected $valueTransformer;
    protected $path;
    public function __construct($rowBuilderFactory, $columnIndexTransformer, $valueTransformer, $path)
    {
        $this->rowBuilderFactory = $rowBuilderFactory;
        $this->columnIndexTransformer = $columnIndexTransformer;
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
    public function getRowBuilderFactory()
    {
        return $this->rowBuilderFactory;
    }
    public function getColumnIndexTransformer()
    {
        return $this->columnIndexTransformer;
    }
}
