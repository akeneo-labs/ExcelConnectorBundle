<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Reader;

use Akeneo\Bundle\BatchBundle\Entity\StepExecution;
use PhpSpec\ObjectBehavior;

class AbstractIteratorReaderSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf('Pim\Bundle\ExcelConnectorBundle\Tests\Stubs\Reader\ArrayIteratorReader');
    }

    public function it_is_initializable()
    {
        $this->beConstructedWith(array());
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Tests\Stubs\Reader\ArrayIteratorReader');
    }

    public function it_iterates_through_values()
    {
        $values = array('value1', 'value2', 'value3');
        $this->beConstructedWith($values);
        foreach ($values as $value) {
            $this->read()->shouldReturn($value);
        }
        $this->read()->shouldReturn(null);
    }

    public function it_sends_all_values_in_batch_mode()
    {
        $values = array('value1', 'value2', 'value3');
        $this->beConstructedWith($values, true);
        $this->read()->shouldReturn($values);
        $this->read()->shouldReturn(null);
    }

    public function it_increments_the_summary_info(StepExecution $stepExecution)
    {
        $values = array('value1', 'value2', 'value3');
        $this->beConstructedWith($values);
        $this->setStepExecution($stepExecution);
        $stepExecution->incrementSummaryInfo('read')->shouldBeCalledTimes(count($values));
        for ($i=0; $i < count($values); $i++) {
            $this->read();
        }
    }

    public function it_can_be_resetted()
    {
        $values = array('value1', 'value2', 'value3');
        $this->beConstructedWith($values);
        foreach ($values as $value) {
            $this->read()->shouldReturn($value);
        }
        $this->reset();
        foreach ($values as $value) {
            $this->read()->shouldReturn($value);
        }
    }
}
