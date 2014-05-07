<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;

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
        $this->get('164')->shouldReturn('GENERAL');
        $this->get('165')->shouldReturn('DD/MM/YY\ HH:MM');
        $this->get('166')->shouldReturn('DD/MM/YY');
    }

    public function it_throws_an_exception_if_there_is_no_style()
    {
        $this->shouldThrow('\InvalidArgumentException')->duringGet('bogus');
    }
}
