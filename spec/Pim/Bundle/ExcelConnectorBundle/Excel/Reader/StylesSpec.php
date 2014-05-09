<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\Styles;

class StylesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(__DIR__ . '/../../fixtures/styles.xml');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Excel\Reader\Styles');
    }

    public function it_returns_shared_strings()
    {
        $this->get(0)->shouldReturn(Styles::FORMAT_DEFAULT);
        $this->get(1)->shouldReturn(Styles::FORMAT_DATE);
        $this->get(2)->shouldReturn(Styles::FORMAT_DEFAULT);
        $this->get(3)->shouldReturn(Styles::FORMAT_DATE);
        $this->get(4)->shouldReturn(Styles::FORMAT_DATE);
    }

    public function it_throws_an_exception_if_there_is_no_style()
    {
        $this->shouldThrow('\InvalidArgumentException')->duringGet('bogus');
    }
}
