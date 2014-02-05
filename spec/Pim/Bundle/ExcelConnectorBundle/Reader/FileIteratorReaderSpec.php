<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Reader;

use ArrayIterator;
use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Iterator\FileIteratorFactory;
use Symfony\Component\HttpFoundation\File\File;

class FileIteratorReaderSpec extends ObjectBehavior
{
    protected $iteratorFactory;

    public function let(FileIteratorFactory $iteratorFactory)
    {
        $this->iteratorFactory = $iteratorFactory;
        $this->beConstructedWith($iteratorFactory, 'iterator_class', array('iterator_options'));
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Reader\FileIteratorReader');
    }

    public function it_calls_the_iterator_factory()
    {
        $values = array('value1', 'value2', 'value3');
        $this->iteratorFactory->create('iterator_class', 'file_path', array('iterator_options'))
            ->willReturn(new ArrayIterator($values));

        $this->setFilePath('file_path');
        foreach ($values as $value) {
            $this->read()->shouldReturn($value);
        }
    }

    public function it_initializes_iterators(\Iterator $iterator)
    {
        $iterator->implement('Pim\Bundle\ExcelConnectorBundle\Iterator\InitializableIteratorInterface');
        $iterator->initialize()->shouldBeCalledTimes(1);
        $iterator->valid()->willReturn(false);
        $this->setFilePath('file_path');
        $this->iteratorFactory->create('iterator_class', 'file_path', array('iterator_options'))
            ->willReturn($iterator);
        $this->read()->shouldReturn(null);
    }

    public function it_has_a_file_path_property()
    {
        $this->setFilePath('file_path');
        $this->getFilePath()->shouldReturn('file_path');
    }

    public function it_has_an_uploadable_property()
    {
        $this->shouldNotBeUploadAllowed();
        $this->setUploadAllowed(true);
        $this->shouldBeUploadAllowed();
        $this->setUploadAllowed(false);
        $this->shouldNotBeUploadAllowed();
    }

    public function it_has_file_upload_capability(File $file)
    {
        $file->getRealPath()->willReturn('file_path');
        $this->setUploadedFile($file);
        $this->getFilePath()->shouldReturn('file_path');
    }
}
