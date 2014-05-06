<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\SharedStrings;

class ValueTransformerFactorySpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader\StubValueTransformer');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Excel\Reader\ValueTransformerFactory');
    }

    public function it_creates_value_transformers(SharedStrings $sharedStrings)
    {
        $this->create($sharedStrings)->getSharedStrings()->shouldReturn($sharedStrings);
    }
}

class StubValueTransformer
{
    protected $valueTransformer;
    public function __construct($valueTransformer)
    {
        $this->valueTransformer = $valueTransformer;
    }
    public function getValueTransformer()
    {
        return $this->valueTransformer;
    }
}
