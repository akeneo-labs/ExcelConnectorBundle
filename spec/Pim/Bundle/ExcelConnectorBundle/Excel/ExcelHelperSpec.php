<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel;

use PhpSpec\ObjectBehavior;

class ExcelHelperSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Excel\ExcelHelper');
    }

    public function it_should_combine_arrays_with_less_keys_than_values()
    {
        $keys = array('key1', 'key2');
        $values = array('value1', 'value2', 'value3');
        $this->combineArrays($keys, $values)->shouldReturn(array('key1' => 'value1', 'key2' => 'value2'));
    }

    public function it_should_combine_arrays_with_more_keys_than_values()
    {
        $keys = array('key1', 'key2', 'key3');
        $values = array('value1', 'value2');
        $this->combineArrays($keys, $values)->shouldReturn(array('key1' => 'value1', 'key2' => 'value2', 'key3' => ''));
    }

    public function it_should_read_a_row_by_row_number()
    {
        $worksheet = $this->getWorksheet('helper.xlsx', 'main');

        $this->getRowDataForRowNumber($worksheet, 2)->shouldReturn(array('value1', 'value2', 'value3', 'value4'));
    }

    public function it_should_read_a_row_by_row_number_with_column_start()
    {
        $worksheet = $this->getWorksheet('helper.xlsx', 'main');

        $this->getRowDataForRowNumber($worksheet, 2, 2)->shouldReturn(array('value3', 'value4'));
    }

    public function it_should_trim_empty_formatted_cells()
    {
        $worksheet = $this->getWorksheet('helper.xlsx', 'main');

        $this->getRowDataForRowNumber($worksheet, 3)->shouldReturn(array('value1', 'value2'));
    }

    /**
     * Returns a worksheet by file name and worksheet name
     *
     * @param string $fileName
     * @param string $worksheetName
     *
     * @return \PHPExcel_Worksheet
     */
    public function getWorksheet($fileName, $worksheetName)
    {
        $reader = new \PHPExcel_Reader_Excel2007;
        $xls = $reader->load(__DIR__ . '/../fixtures/' . $fileName);

        return $xls->getSheetByName($worksheetName);
    }
}
