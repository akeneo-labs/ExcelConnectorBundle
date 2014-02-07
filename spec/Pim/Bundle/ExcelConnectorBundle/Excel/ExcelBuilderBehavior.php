<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel;

use PhpSpec\ObjectBehavior;

/**
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ExcelBuilderBehavior extends ObjectBehavior
{

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
