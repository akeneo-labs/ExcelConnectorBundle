<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;

class SharedStringsSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(__DIR__ . '/../../fixtures/sharedStrings.xml');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Excel\Reader\SharedStrings');
    }

    public function it_returns_shared_strings()
    {
        $this->get(0)->shouldReturn('value1');
        $this->get(2)->shouldReturn('  ');
        $this->get(4)->shouldReturn('value3');
        $this->get(5)->shouldReturn('value4');
    }
}
