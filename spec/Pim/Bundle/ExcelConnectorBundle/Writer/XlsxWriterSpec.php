<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Writer;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Excel\ExcelBuilderFactory;
use Pim\Bundle\ExcelConnectorBundle\Excel\ExcelBuilderInterface;

class XlsxWriterSpec extends ObjectBehavior
{
    protected $filePath;

    public function let(ExcelBuilderFactory $factory, ExcelBuilderInterface $builder)
    {
        $this->beConstructedWith($factory, 'class', ['options']);
        $factory->create('class', ['options'])->willReturn($builder);
        $this->initialize();
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Writer\XlsxWriter');
    }

    public function it_adds_item_to_the_builder(ExcelBuilderInterface $builder)
    {
        $builder->add(['item1'])->shouldBecalled();
        $builder->add(['item2'])->shouldBecalled();
        $this->write([['item1'],['item2']]);
    }

    public function it_creates_an_excel_file_on_flush(ExcelBuilderInterface $builder)
    {
        $this->filePath = tempnam('/tmp', 'spec');
        $this->setFilePath($this->filePath);
        unlink($this->filePath);
        $builder->getExcelObject()->willReturn(new \PHPExcel);
        $this->flush();
        if (!file_exists($this->filePath)) {
            throw new \PhpSpec\Exception\Example\FailureException('No created file');
        }
    }

    public function letDown()
    {
        if ($this->filePath && file_exists($this->filePath)) {
            unlink($this->filePath);
        }
    }
}
