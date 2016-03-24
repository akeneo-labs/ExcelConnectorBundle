<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Iterator;

use Akeneo\Component\SpreadsheetParser\SpreadsheetInterface;
use Akeneo\Component\SpreadsheetParser\SpreadsheetLoaderInterface;
use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Iterator\ArrayHelper;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

class XlsxFileIteratorSpec extends ObjectBehavior
{
    public function let(
        ContainerInterface $container,
        ArrayHelper $arrayHelper,
        SpreadsheetLoaderInterface $spreadsheetReader,
        SpreadsheetInterface $spreadsheet
    ) {
        $spreadsheetReader->open('path')->willReturn($spreadsheet);
        $arrayHelper->combineArrays(Argument::type('array'), Argument::type('array'))->will(
            function ($args) {
                return array_combine($args[0], $args[1]);
            }
        );
        $container->get('pim_excel_connector.iterator.array_helper')->willReturn($arrayHelper);
        $container->get('akeneo_spreadsheet_parser.spreadsheet_loader')->willReturn($spreadsheetReader);

        $spreadsheet->createRowIterator(0, [])->willReturn(
            new \ArrayIterator(
                [
                    1 => ['tab1_column1', 'tab1_column2'],
                    2 => ['tab1_value1', 'tab1_value2'],
                    3 => ['tab1_value3', 'tab1_value4'],
                    4 => ['tab1_value5', 'tab1_value6']
                ]
            )
        );
        $spreadsheet->createRowIterator(1, [])->willReturn(
            new \ArrayIterator(
                [
                    1 => ['tab2_column1', 'tab2_column2'],
                    2 => ['tab2_value1', 'tab2_value2'],
                    3 => ['tab2_value3', 'tab2_value4'],
                ]
            )
        );
        $spreadsheet->createRowIterator(2, [])->willReturn(
            new \ArrayIterator(
                [
                    1 => ['tab3_column1', 'tab3_column2'],
                    2 => ['tab3_value1', 'tab3_value2'],
                    3 => ['tab3_value3', 'tab3_value4'],
                ]
            )
        );
        $spreadsheet->createRowIterator(3, [])->willReturn(
            new \ArrayIterator(
                [
                    2 => ['tab4_column1', 'tab4_column2'],
                    4 => ['tab4_value1', 'tab4_value2'],
                    5 => ['tab4_value3', 'tab4_value4'],
                ]
            )
        );
    }

    public function it_is_initializable()
    {
        $this->beConstructedWith(__DIR__ . '/../fixtures/lists.xlsx', array());
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Iterator\XlsxFileIterator');
    }

    public function it_can_read_multiple_tabs(
            ContainerInterface $container,
            SpreadsheetInterface $spreadsheet
        ) {
        $this->beConstructedWith('path', array());
        $this->setContainer($container);

        $spreadsheet->getWorksheets()->willReturn(['tab1', 'tab2', 'tab3']);

        $this->rewind();
        $values = array(
            array('tab1_column1' => 'tab1_value1', 'tab1_column2' => 'tab1_value2'),
            array('tab1_column1' => 'tab1_value3', 'tab1_column2' => 'tab1_value4'),
            array('tab1_column1' => 'tab1_value5', 'tab1_column2' => 'tab1_value6'),
            array('tab2_column1' => 'tab2_value1', 'tab2_column2' => 'tab2_value2'),
            array('tab2_column1' => 'tab2_value3', 'tab2_column2' => 'tab2_value4'),
            array('tab3_column1' => 'tab3_value1', 'tab3_column2' => 'tab3_value2'),
            array('tab3_column1' => 'tab3_value3', 'tab3_column2' => 'tab3_value4'),
        );
        foreach ($values as $row) {
            $this->current()->shouldReturn($row);
            $this->next();
        }
        $this->valid()->shouldReturn(false);
    }

    public function it_can_filter_non_included_tabs(
        ContainerInterface $container,
        SpreadsheetInterface $spreadsheet
    ) {
        $this->beConstructedWith('path', array('include_worksheets' => array('/included/')));
        $spreadsheet->getWorksheets()->willReturn(['included1', 'included2', 'tab3']);

        $this->setContainer($container);
        $this->rewind();
        $values = array(
            array('tab1_column1' => 'tab1_value1', 'tab1_column2' => 'tab1_value2'),
            array('tab1_column1' => 'tab1_value3', 'tab1_column2' => 'tab1_value4'),
            array('tab1_column1' => 'tab1_value5', 'tab1_column2' => 'tab1_value6'),
            array('tab2_column1' => 'tab2_value1', 'tab2_column2' => 'tab2_value2'),
            array('tab2_column1' => 'tab2_value3', 'tab2_column2' => 'tab2_value4'),
        );
        foreach ($values as $row) {
            $this->current()->shouldReturn($row);
            $this->next();
        }
        $this->valid()->shouldReturn(false);
    }

    public function it_can_filter_excluded_tabs(
        ContainerInterface $container,
        SpreadsheetInterface $spreadsheet
    ) {
        $this->beConstructedWith('path', array('exclude_worksheets' => array('/excluded/')));
        $spreadsheet->getWorksheets()->willReturn(['tab1', 'tab2', 'excluded']);

        $this->setContainer($container);
        $this->rewind();
        $values = array(
            array('tab1_column1' => 'tab1_value1', 'tab1_column2' => 'tab1_value2'),
            array('tab1_column1' => 'tab1_value3', 'tab1_column2' => 'tab1_value4'),
            array('tab1_column1' => 'tab1_value5', 'tab1_column2' => 'tab1_value6'),
            array('tab2_column1' => 'tab2_value1', 'tab2_column2' => 'tab2_value2'),
            array('tab2_column1' => 'tab2_value3', 'tab2_column2' => 'tab2_value4'),
        );
        foreach ($values as $row) {
            $this->current()->shouldReturn($row);
            $this->next();
        }
        $this->valid()->shouldReturn(false);
    }

    public function it_can_filter_included_and_excluded_tabs(
        ContainerInterface $container,
        SpreadsheetInterface $spreadsheet
    ) {
        $spreadsheet->getWorksheets()->willReturn(['excluded', 'included excluded', 'included']);
        $this->beConstructedWith(
            'path',
            array(
                'exclude_worksheets' => array('/excluded/'),
                'include_worksheets' => array('/included/'),
            )
        );
        $this->setContainer($container);
        $this->rewind();
        $values = array(
            array('tab3_column1' => 'tab3_value1', 'tab3_column2' => 'tab3_value2'),
            array('tab3_column1' => 'tab3_value3', 'tab3_column2' => 'tab3_value4'),
        );
        foreach ($values as $row) {
            $this->current()->shouldReturn($row);
            $this->next();
        }
        $this->valid()->shouldReturn(false);
    }

    public function it_can_use_a_different_data_range(
        ContainerInterface $container,
        SpreadsheetInterface $spreadsheet
    ) {
        $spreadsheet->getWorksheets()->willReturn(['tab1', 'tab2', 'tab3', 'included']);
        $this->beConstructedWith(
            'path',
            array(
                'label_row' => 2,
                'data_row'  => 4,
                'include_worksheets' => array('/included/')
            )
        );
        $this->setContainer($container);
        $this->rewind();
        $values = array(
            array('tab4_column1' => 'tab4_value1', 'tab4_column2' => 'tab4_value2'),
            array('tab4_column1' => 'tab4_value3', 'tab4_column2' => 'tab4_value4'),
        );
        foreach ($values as $row) {
            $this->current()->shouldReturn($row);
            $this->next();
        }
        $this->valid()->shouldReturn(false);
    }
}
