<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Reader;

use Akeneo\Bundle\BatchBundle\Entity\StepExecution;
use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Reader\AbstractIteratorReader;

class AbstractIteratorReaderSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf('spec\Pim\Bundle\ExcelConnectorBundle\Reader\ArrayIteratorReader');
    }

    public function it_is_initializable()
    {
        $this->beConstructedWith([]);
        $this->shouldHaveType('spec\Pim\Bundle\ExcelConnectorBundle\Reader\ArrayIteratorReader');
    }

    public function it_iterates_through_values()
    {
        $values = [
            ['value11', 'value12', 'value13'],
            ['value21', 'value22', 'value23'],
        ];
        $this->beConstructedWith($values);
        foreach ($values as $value) {
            $this->read()->shouldReturn($value);
        }
        $this->read()->shouldReturn(null);
    }

    public function it_sends_all_values_in_batch_mode()
    {
        $values = [
            ['value11', 'value12', 'value13'],
            ['value21', 'value22', 'value23'],
        ];
        $this->beConstructedWith($values, true);
        $this->read()->shouldReturn($values);
        $this->read()->shouldReturn(null);
    }

    public function it_increments_the_summary_info(StepExecution $stepExecution)
    {
        $values = [
            ['value11', 'value12', 'value13'],
            ['value21', 'value22', 'value23'],
        ];
        $this->beConstructedWith($values);
        $this->setStepExecution($stepExecution);
        $stepExecution->incrementSummaryInfo('read')->shouldBeCalledTimes(count($values));
        for ($i = 0; $i < count($values); $i++) {
            $this->read();
        }
    }

    public function it_can_be_resetted()
    {
        $values = [
            ['value11', 'value12', 'value13'],
            ['value21', 'value22', 'value23'],
        ];
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

class ArrayIteratorReader extends AbstractIteratorReader
{
    /**
     * @var array
     */
    protected $values;

    public function __construct(array $values, $batchMode = false)
    {
        $this->values = $values;
        parent::__construct($batchMode);
    }

    protected function createIterator()
    {
        return new \ArrayIterator($this->values);
    }

    public function getConfigurationFields()
    {
        return [];
    }
}
