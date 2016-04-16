<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Iterator;

use Pim\Bundle\ExcelConnectorBundle\Iterator\ArrayHelper;
use Akeneo\Component\SpreadsheetParser\SpreadsheetInterface;
use Akeneo\Component\SpreadsheetParser\SpreadsheetLoaderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

require_once __DIR__ . '/XlsxFileIteratorBehavior.php';

class AttributeXlsxFileIteratorSpec extends XlsxFileIteratorBehavior
{
    public function let(
        ContainerInterface $container,
        ArrayHelper $arrayHelper,
        SpreadsheetLoaderInterface $spreadsheetReader,
        SpreadsheetInterface $spreadsheet
    )  {
        parent::let($container, $arrayHelper, $spreadsheetReader, $spreadsheet);
        $this->beConstructedWith('path', [ 'include_worksheets' => ['/tab/']]);
        $spreadsheet->getWorksheets()->willReturn(['tab1', 'tab2', 'attribute_types']);
        $spreadsheet->getWorksheetIndex('attribute_types')->willReturn(2);
        $spreadsheet->createRowIterator(0, [])->willReturn(
            new \ArrayIterator(
                [
                    1 => ['code', 'use_as_label', 'type','key1', 'key2', 'key3'],
                    2 => ['attribute1', '1', 'type1', 'value1', 'value2', 'value3'],
                    3 => ['attribute2', '1', '', '', '', ''],
                    4 => ['attribute3', '1', 'type2', 'value4', '', '']
                ]
            )
        );
        $spreadsheet->createRowIterator(1, [])->willReturn(
            new \ArrayIterator(
                [
                    1 => ['code', 'use_as_label', 'type', 'key4', 'key1', 'key2'],
                    2 => ['attribute4', '1', 'type3', 'value5', '', ''],
                    3 => ['attribute5', '1', '', '', '', ''],
                ]
            )
        );
        $spreadsheet->createRowIterator(2, [])->willReturn(
            new \ArrayIterator(
                [
                    1 => ['code', 'title'],
                    2 => ['pim_type1', 'type1'],
                    3 => ['pim_type2', 'type2'],
                    4 => ['pim_type3', 'type3'],
                ]
            )
        );
        $this->setContainer($container);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Iterator\AttributeXlsxFileIterator');
    }

    public function it_reads_attributes()
    {
        $values = [
            ['code' => 'attribute1', 'type' => 'pim_type1', 'key1' => 'value1', 'key2' => 'value2', 'key3' => 'value3'],
            ['code' => 'attribute3', 'type' => 'pim_type2', 'key1' => 'value4'],
            ['code' => 'attribute4', 'type' => 'pim_type3', 'key4' => 'value5'],
        ];

        $this->rewind();
        foreach ($values as $item) {
            $this->current()->shouldReturn($item);
            $this->next();
        }

        $this->valid()->shouldReturn(false);
    }
}
