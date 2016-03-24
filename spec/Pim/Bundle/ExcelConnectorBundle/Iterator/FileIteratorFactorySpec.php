<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Iterator;

use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FileIteratorFactorySpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->beConstructedWith($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Iterator\FileIteratorFactory');
    }

    function it_creates_objects()
    {
        $this->create('stdClass', 'file')->shouldHaveType('stdClass');
    }
}
