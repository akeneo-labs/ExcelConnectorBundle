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

    /**
     * Returns a worksheet by file name and worksheet name
     *
     * @param string $fileName
     * @param string $worksheetName
     *
     * @return \SpreadsheetReader_XLSX
     */
    public function getWorksheet($fileName, $worksheetName)
    {
        $xls = new \SpreadsheetReader(__DIR__ . '/../fixtures/' . $fileName);

        $worksheets = $xls->Sheets();
        $xls->ChangeSheet(array_search($worksheetName, $worksheets));

        return $xls;
    }
}
