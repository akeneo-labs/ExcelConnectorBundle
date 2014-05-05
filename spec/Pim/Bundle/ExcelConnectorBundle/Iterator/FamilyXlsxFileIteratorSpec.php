<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Iterator;

use Pim\Bundle\ExcelConnectorBundle\Iterator\ArrayHelper;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\Workbook;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\WorkbookLoader;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FamilyXlsxFileIteratorSpec extends XlsxFileIteratorBehavior
{
    public function let(
        ContainerInterface $container,
        ArrayHelper $arrayHelper,
        WorkbookLoader $workbookReader,
        Workbook $workbook
    ) {
        parent::let($container, $arrayHelper, $workbookReader, $workbook);
        $workbook->getWorksheets()->willReturn(['bogus', 'family1', 'family2']);
        $workbook->createRowIterator(1)->willReturn(
            new \ArrayIterator(
                [
                    1  => ['', '', '', '', 'locale1', 'locale2'],
                    2  => ['bogus', 'family1', 'bogus', 'bogus', 'family1_locale1', 'family1_locale2'],
                    3  => [],
                    5  => ['', '', '', '', 'channel1', 'channel2'],
                    6  => ['code', 'use_as_label', 'column1', 'column2'],
                    8  => ['attribute1', '', 'bogus', 'bogus', '1', ''],
                    10 => ['attribute2', '1', 'bogus', 'bogus', '1', '1'],
                    11 => ['attribute3', '', '', '', '', '1'],
                ]
            )
        );
        $workbook->createRowIterator(2)->willReturn(
            new \ArrayIterator(
                [
                    1  => ['', '', '', '', 'locale1', 'locale2'],
                    2  => ['bogus', 'family2', 'bogus', 'bogus', 'family2_locale1', 'family2_locale2'],
                    3  => [],
                    5  => ['', '', '', '', 'channel1', 'channel2'],
                    6  => ['code', 'use_as_label', 'column1', 'column2'],
                    7  => ['attribute1', '1', 'bogus', 'bogus', '1', ''],
                    10 => ['attribute5', '', 'bogus', 'bogus', '1', '1'],
                    11 => ['attribute6', '', '', '', '', '1'],
                    12 => ['attribute7', '', '', '', '', ''],
                ]
            )
        );
        $this->beConstructedWith(
            'path',
            [
              'channel_label_row'   => 5,
              'attribute_label_row' => 6,
              'attribute_data_row'  => 7,
              'code_row'            => 2,
              'code_column'         => 1,
              'labels_label_row'    => 1,
              'labels_data_row'     => 2,
              'labels_column'       => 4,
              'include_worksheets'  => [ '/^family/' ]
            ]
        );
        $this->setContainer($container);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Iterator\FamilyXlsxFileIterator');
    }

    public function it_reads_families()
    {
        $this->rewind();
        $values = [
            [
                'attributes' => ['attribute1', 'attribute2', 'attribute3'],
                'code' => 'family1',
                'labels' => ['locale1' => 'family1_locale1', 'locale2' => 'family1_locale2'],
                'requirements' => [
                    'channel1' => ['attribute1', 'attribute2'],
                    'channel2' => ['attribute2', 'attribute3']
                ],
                'attribute_as_label' =>  'attribute2',
            ],
            [
                'attributes' => ['attribute1', 'attribute5', 'attribute6', 'attribute7'],
                'code' => 'family2',
                'labels' => ['locale1' => 'family2_locale1', 'locale2' => 'family2_locale2'],
                'requirements' => [
                    'channel1' => ['attribute1', 'attribute5'],
                    'channel2' => ['attribute5', 'attribute6']
                ],
                'attribute_as_label' =>  'attribute1',
            ]
        ];

        foreach ($values as $item) {
            $this->current()->shouldReturn($item);
            $this->next();
        }

        $this->valid()->shouldReturn(false);
    }
}
