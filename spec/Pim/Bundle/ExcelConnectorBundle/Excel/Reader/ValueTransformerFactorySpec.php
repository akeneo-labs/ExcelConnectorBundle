<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\DateTransformer;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\SharedStrings;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\Styles;

class ValueTransformerFactorySpec extends ObjectBehavior
{
    public function let(DateTransformer $dateTransformer)
    {
        $this->beConstructedWith($dateTransformer, 'spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader\StubValueTransformer');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Excel\Reader\ValueTransformerFactory');
    }

    public function it_creates_value_transformers(
        DateTransformer $dateTransformer,
        SharedStrings $sharedStrings,
        Styles $styles
    ) {
        $transformer = $this->create($sharedStrings, $styles);
        $transformer->getSharedStrings()->shouldReturn($sharedStrings);
        $transformer->getDateTransformer()->shouldReturn($dateTransformer);
        $transformer->getStyles()->shouldReturn($styles);
    }
}

class StubValueTransformer
{
    protected $dateTransformer;
    protected $sharedStrings;
    protected $styles;
    public function __construct($dateTransformer, $sharedStrings, $styles)
    {
        $this->sharedStrings = $sharedStrings;
        $this->dateTransformer = $dateTransformer;
        $this->styles = $styles;
    }
    public function getSharedStrings()
    {
        return $this->sharedStrings;
    }

    public function getDateTransformer()
    {
        return $this->dateTransformer;
    }
    public function getStyles()
    {
        return $this->styles;
    }
}
