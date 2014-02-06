<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Iterator;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Excel\ExcelHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;

class XlsxFileIteratorSpec extends ObjectBehavior
{
    public function let(ContainerInterface $container)
    {
        $helper = new ExcelHelper;
        $container->get('pim_excel_connector.excel.helper')->willReturn($helper);
    }

    public function it_is_initializable()
    {
        $this->beConstructedWith(__DIR__ . '/../fixtures/lists.xlsx', array());
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Iterator\XlsxFileIterator');
    }

    public function it_can_read_multiple_tabs(ContainerInterface $container)
    {
        $this->beConstructedWith(__DIR__ . '/../fixtures/lists.xlsx', array());
        $this->setContainer($container);
        $this->rewind();
        $values = array(
            array('tab1_column1' => 'tab1_value1', 'tab1_column2' => 'tab1_value3'),
            array('tab1_column1' => 'tab1_value2', 'tab1_column2' => 'tab1_value4'),
            array('tab2_column1' => 'tab2_value1', 'tab2_column2' => 'tab2_value3'),
            array('tab2_column1' => 'tab2_value2', 'tab2_column2' => 'tab2_value4'),
            array('tab3_column1' => 'tab3_value1', 'tab3_column2' => 'tab3_value3'),
            array('tab3_column1' => 'tab3_value2', 'tab3_column2' => 'tab3_value4'),
            array('tab4_column1' => 'tab4_value1', 'tab4_column2' => 'tab4_value3'),
            array('tab4_column1' => 'tab4_value2', 'tab4_column2' => 'tab4_value4'),
        );
        foreach ($values as $row) {
            $this->current()->shouldReturn($row);
            $this->next();
        }
        $this->valid()->shouldReturn(false);
    }

    public function it_can_filter_non_included_tabs(ContainerInterface $container)
    {
        $this->beConstructedWith(
            __DIR__ . '/../fixtures/lists.xlsx',
            array('include_worksheets' => array('/included/'))
        );
        $this->setContainer($container);
        $this->rewind();
        $values = array(
            array('tab1_column1' => 'tab1_value1', 'tab1_column2' => 'tab1_value3'),
            array('tab1_column1' => 'tab1_value2', 'tab1_column2' => 'tab1_value4'),
            array('tab2_column1' => 'tab2_value1', 'tab2_column2' => 'tab2_value3'),
            array('tab2_column1' => 'tab2_value2', 'tab2_column2' => 'tab2_value4'),
            array('tab4_column1' => 'tab4_value1', 'tab4_column2' => 'tab4_value3'),
            array('tab4_column1' => 'tab4_value2', 'tab4_column2' => 'tab4_value4'),
        );
        foreach ($values as $row) {
            $this->current()->shouldReturn($row);
            $this->next();
        }
        $this->valid()->shouldReturn(false);
    }

    public function it_can_filter_excluded_tabs(ContainerInterface $container)
    {
        $this->beConstructedWith(
            __DIR__ . '/../fixtures/lists.xlsx',
            array('exclude_worksheets' => array('/excluded/'))
        );
        $this->setContainer($container);
        $this->rewind();
        $values = array(
            array('tab1_column1' => 'tab1_value1', 'tab1_column2' => 'tab1_value3'),
            array('tab1_column1' => 'tab1_value2', 'tab1_column2' => 'tab1_value4'),
            array('tab2_column1' => 'tab2_value1', 'tab2_column2' => 'tab2_value3'),
            array('tab2_column1' => 'tab2_value2', 'tab2_column2' => 'tab2_value4'),
            array('tab3_column1' => 'tab3_value1', 'tab3_column2' => 'tab3_value3'),
            array('tab3_column1' => 'tab3_value2', 'tab3_column2' => 'tab3_value4'),
        );
        foreach ($values as $row) {
            $this->current()->shouldReturn($row);
            $this->next();
        }
        $this->valid()->shouldReturn(false);
    }

    public function it_can_filter_included_and_excluded_tabs(ContainerInterface $container)
    {
        $this->beConstructedWith(
            __DIR__ . '/../fixtures/lists.xlsx',
            array(
                'exclude_worksheets' => array('/excluded/'),
                'include_worksheets' => array('/included/'),
            )
        );
        $this->setContainer($container);
        $this->rewind();
        $values = array(
            array('tab1_column1' => 'tab1_value1', 'tab1_column2' => 'tab1_value3'),
            array('tab1_column1' => 'tab1_value2', 'tab1_column2' => 'tab1_value4'),
            array('tab2_column1' => 'tab2_value1', 'tab2_column2' => 'tab2_value3'),
            array('tab2_column1' => 'tab2_value2', 'tab2_column2' => 'tab2_value4'),
        );
        foreach ($values as $row) {
            $this->current()->shouldReturn($row);
            $this->next();
        }
        $this->valid()->shouldReturn(false);
    }

    public function it_can_use_a_different_data_range(ContainerInterface $container)
    {
        $this->beConstructedWith(
            __DIR__ . '/../fixtures/with_header.xlsx',
            array(
                'label_row' => 2,
                'data_row'  => 4
            )
        );
        $this->setContainer($container);
        $this->rewind();
        $values = array(
            array('column1' => 'value1', 'column2' => 'value2'),
            array('column1' => 'value3', 'column2' => 'value4'),
        );
        foreach ($values as $row) {
            $this->current()->shouldReturn($row);
            $this->next();
        }
        $this->valid()->shouldReturn(false);
    }

    public function it_can_skip_empty_values(ContainerInterface $container)
    {
        $this->beConstructedWith(
            __DIR__ . '/../fixtures/with_empty.xlsx',
            array(
                'skip_empty' => true,
            )
        );
        $this->setContainer($container);
        $this->rewind();
        $values = array(
            array('column1' => 'value1', 'column3' => 'value2'),
            array('column1' => 'value3', 'column2' => 'value4'),
        );
        foreach ($values as $row) {
            $this->current()->shouldReturn($row);
            $this->next();
        }
        $this->valid()->shouldReturn(false);
    }
}
