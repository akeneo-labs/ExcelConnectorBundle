<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Builder;

use PhpSpec\ObjectBehavior;

class ExcelBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Excel\Builder\ExcelBuilder');
    }

    function it_creates_excel_objects()
    {
        $this->getExcelObject()->shouldHaveType('\PHPExcel');
    }

    function it_can_use_homogenous_data()
    {
        $this->add(['col1' => 'value1', 'col2' => 'value2']);
        $this->add(['col1' => 'value3', 'col2' => 'value4']);
        $this->add(['col1' => 'value5', 'col2' => 'value6']);
        $excelObject = $this->getExcelObject();
        $excelObject->shouldHaveCellRow('EXPORT', 1, ['col1', 'col2']);
        $excelObject->shouldHaveCellRow('EXPORT', 2, ['value1', 'value2']);
        $excelObject->shouldHaveCellRow('EXPORT', 3, ['value3', 'value4']);
        $excelObject->shouldHaveCellRow('EXPORT', 4, ['value5', 'value6']);
    }

    function it_can_use_heterogenous_data()
    {
        $this->add(['col1' => 'value1', 'col2' => 'value2']);
        $this->add(['col2' => 'value4', 'col1' => 'value3']);
        $this->add(['col3' => 'value6', 'col1' => 'value5']);
        $excelObject = $this->getExcelObject();
        $excelObject->shouldHaveCellRow('EXPORT', 1, ['col1', 'col2', 'col3']);
        $excelObject->shouldHaveCellRow('EXPORT', 2, ['value1', 'value2']);
        $excelObject->shouldHaveCellRow('EXPORT', 3, ['value3', 'value4']);
        $excelObject->shouldHaveCellRow('EXPORT', 4, ['value5', null, 'value6']);
    }

    function it_can_use_different_rows()
    {
        $this->beConstructedWith(['label_row' => 2, 'data_row' => 4]);
        $this->add(['col1' => 'value1', 'col2' => 'value2']);
        $this->add(['col1' => 'value3', 'col2' => 'value4']);
        $this->add(['col1' => 'value5', 'col2' => 'value6']);
        $excelObject = $this->getExcelObject();
        $excelObject->shouldHaveCellRow('EXPORT', 2, ['col1', 'col2']);
        $excelObject->shouldHaveCellRow('EXPORT', 4, ['value1', 'value2']);
        $excelObject->shouldHaveCellRow('EXPORT', 5, ['value3', 'value4']);
        $excelObject->shouldHaveCellRow('EXPORT', 6, ['value5', 'value6']);
    }

    function it_can_have_a_custom_worksheet_name()
    {
        $this->beConstructedWith(['worksheet_name' => 'CUSTOM']);
        $this->add(['col1' => 'value1', 'col2' => 'value2']);
        $this->add(['col1' => 'value3', 'col2' => 'value4']);
        $this->add(['col1' => 'value5', 'col2' => 'value6']);
        $excelObject = $this->getExcelObject();
        $excelObject->shouldHaveCellRow('CUSTOM', 1, ['col1', 'col2']);
        $excelObject->shouldHaveCellRow('CUSTOM', 2, ['value1', 'value2']);
        $excelObject->shouldHaveCellRow('CUSTOM', 3, ['value3', 'value4']);
        $excelObject->shouldHaveCellRow('CUSTOM', 4, ['value5', 'value6']);
    }

    public function getMatchers()
    {
        return [
            'haveCellValue' => [$this, 'hasCellValue'],
            'haveCellRow' => [$this, 'hasCellRow']
        ];
    }

    public function hasCellValue(\PHPExcel $excelObject, $worksheetName, $coordinate, $value)
    {
        $worksheet = $excelObject->getSheetByName($worksheetName);
        if (!$worksheet) {
            return false;
        }

        return $worksheet->getCell($coordinate)->getValue() === $value;
    }

    public function hasCellRow(\PHPExcel $excelObject, $worksheetName, $row, array $values)
    {
        $worksheet = $excelObject->getSheetByName($worksheetName);
        if (!$worksheet) {
            return false;
        }

        $rowIterator = $worksheet->getRowIterator($row);
        if (!$rowIterator->valid()) {
            return false;
        }

        $cellIterator = $rowIterator->current()->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);

        foreach ($cellIterator as $cell) {
            $value = array_shift($values);
            if ($value !== $cell->getValue()) {
                return false;
            }
        }

        return 0 === count($values);
    }
}
