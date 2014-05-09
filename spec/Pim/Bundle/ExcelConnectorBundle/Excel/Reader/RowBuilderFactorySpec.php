<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;

class RowBuilderFactorySpec extends ObjectBehavior
{

    public function let()
    {
        $this->beConstructedWith('spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader\StubRowBuilder');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Excel\Reader\RowBuilderFactory');
    }

    public function it_creates_row_builders()
    {
        $this->create()->shouldHaveType('spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader\StubRowBuilder');
    }
}

class StubRowBuilder
{

}
