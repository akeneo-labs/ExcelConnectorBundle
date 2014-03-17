<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Writer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Pim\Bundle\ExcelConnectorBundle\Writer\Excel2003XmlWriter;

class Excel2003XmlWriterSpec extends ObjectBehavior
{
    protected $tempFile;

    public function let(EncoderInterface $encoder)
    {
        $this->tempFile = tempnam('/tmp', 'excel_2003_xml_writer_spec');
        $this->beConstructedWith(
            $encoder,
            'format',
            __DIR__ . '/../fixtures/excel_2003_header.txt',
            __DIR__ . '/../fixtures/excel_2003_footer.txt'
        );
        $this->setFilePath($this->tempFile);

        $encoder->supportsEncoding('format')->willReturn(true);
        $encoder->encode(Argument::any(), 'format', Argument::any())->will(function ($args) {
            return implode(',', $args[0]) . "\n";
        });
    }

    public function letGo()
    {
        if ($this->tempFile && file_exists($this->tempFile)) {
            unlink($this->tempFile);
            $this->tempFile = null;
        }
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Writer\Excel2003XmlWriter');
    }

    public function it_writes_homogeneous_items()
    {

        $this->initialize();
        $this->write(
            [
                ['column1' => 'value1', 'column2' => 'value2'],
                ['column1' => 'value3', 'column2' => 'value4']
            ]
        );
        $this->flush()->shouldWriteDataInFile(
            2,
            "column1,column2\nvalue1,value2\nvalue3,value4"
        );
    }

    public function it_writes_in_multiple_batches()
    {
        $this->initialize();
        $this->write([['column1' => 'value1', 'column2' => 'value2']]);
        $this->write([['column1' => 'value3', 'column2' => 'value4']]);
        $this->flush()->shouldWriteDataInFile(
            2,
            "column1,column2\nvalue1,value2\nvalue3,value4"
        );
    }

    public function it_writes_heteregoneous_items()
    {
        $this->initialize();
        $this->write(
            [
                ['column1' => 'value1', 'column2' => 'value2'],
                ['column2' => 'value3', 'column3' => 'value4']
            ]
        );
        $this->flush()->shouldWriteDataInFile(
            3,
            "column1,column2,column3\nvalue1,value2\n,value3,value4"
        );
    }

    public function it_writes_empty_files()
    {
        $this->initialize();
        $this->flush()->shouldWriteDataInFile(0, '');
    }

    public function getMatchers()
    {
        return [
            'writeDataInFile' => [$this, 'hasDataInFile']
        ];
    }

    public function hasDataInFile($result, $columnCount, $data)
    {
        $expected =
            "HEADER\n" .
            (
                $columnCount
                ? implode('', array_fill(0,$columnCount, Excel2003XmlWriter::COLUMN_XML)) . $data
                : ''
            ) . "\nFOOTER";

        return $expected === file_get_contents($this->tempFile);
    }

}
