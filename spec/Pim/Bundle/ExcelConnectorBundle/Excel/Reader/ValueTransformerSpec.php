<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\ContentCache;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\ValueTransformer;
use Prophecy\Argument;

class ValueTransformerSpec extends ObjectBehavior
{
    public function let(ContentCache $contentCache)
    {
        $contentCache->get(Argument::type('string'))->will(
            function ($args) {
                return 'shared_' . $args[0];
            }
        );
        $this->beConstructedWith($contentCache);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Excel\Reader\ValueTransformer');
    }

    public function it_transforms_shared_strings()
    {
        $this->transform('1', ValueTransformer::TYPE_SHARED_STRING, '')->shouldReturn('shared_1');
    }

    public function it_transforms_strings()
    {
        $this->transform('string', ValueTransformer::TYPE_STRING, '')->shouldReturn('string');
    }

    public function it_transforms_numbers()
    {
        $this->transform('10.2', ValueTransformer::TYPE_NUMBER, '')->shouldReturn('10.2');
    }
}
