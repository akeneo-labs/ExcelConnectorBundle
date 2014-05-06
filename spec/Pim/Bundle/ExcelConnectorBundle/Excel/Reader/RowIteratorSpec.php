<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\ValueTransformer;
use Prophecy\Argument;

class RowIteratorSpec extends ObjectBehavior
{
    public function let(ValueTransformer $valueTransformer)
    {
        $this->beConstructedWith($valueTransformer, __DIR__ . '/../../fixtures/sheet.xml');
        $valueTransformer->transform(Argument::type('string'))->will(
            function ($args) {
                return (trim($args[0])) ? 'transformed_' . trim($args[0]) : '';
            }
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Excel\Reader\RowIterator');
    }

    public function it_iterates_through_worksheets()
    {
        $values = [
            1 => ['transformed_0', 'transformed_1'],
            2 => ['transformed_2', 'transformed_3', 'transformed_4'],
            4 => ['transformed_5', '', 'transformed_6'],
            6 => ['', 'transformed_1578', 'transformed_37235']
        ];

        $this->rewind();
        foreach ($values as $key => $row) {
            $this->valid()->shouldReturn(true);
            $this->current()->shouldReturn($row);
            $this->key()->shouldReturn($key);
            $this->next();
        }

        $this->valid->shouldReturn(false);
    }

    public function it_can_be_rewinded()
    {
        $this->rewind();
        $this->valid()->shouldReturn(true);
        $this->current()->shouldReturn(['string_0', 'string_1']);
        $this->key()->shouldReturn(1);
        $this->next();
        $this->rewind();
        $this->valid()->shouldReturn(true);
        $this->current()->shouldReturn(['string_0', 'string_1']);
        $this->key()->shouldReturn(1);
    }
}
