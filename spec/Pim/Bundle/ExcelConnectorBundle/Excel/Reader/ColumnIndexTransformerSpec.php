<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;

class ColumnIndexTransformerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Excel\Reader\ColumnIndexTransformer');
    }

    public function it_transforms_single_letter_cell_names()
    {
        $this->transform('A1')->shouldReturn(0);
        $this->transform('D3')->shouldReturn(3);
        $this->transform('F2')->shouldReturn(5);
    }

    public function it_transforms_multiple_letter_cell_names()
    {
    }
}
