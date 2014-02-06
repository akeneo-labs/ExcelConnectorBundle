<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel;

/**
 * Helper methods for Excel files
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ExcelHelper
{
    /**
     * Returns an array of values for a row number
     *
     * @param \PHPExcel_Worksheet $worksheet
     * @param int                 $row
     * @param int                 $startColumn
     *
     * @return array
     */
    public function getRowDataForRowNumber(\PHPExcel_Worksheet $worksheet, $row, $startColumn = 0)
    {
        return $this->getRowData($worksheet->getRowIterator($row)->current(), $startColumn);
    }

    /**
     * Returns an array of values for a row
     *
     * @param \PHPExcel_Worksheet_Row $row
     * @param int                     $startColumn
     *
     * @return array
     */
    public function getRowData(\PHPExcel_Worksheet_Row $row, $startColumn = 0)
    {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);

        $values = array();
        foreach ($cellIterator as $cell) {
            if ($startColumn) {
                $startColumn--;
            } else {
                $values[] = $cell->getValue();
            }
        }

        return $this->trimArray($values);
    }

    /**
     * Combines array of different sizes
     *
     * @param array $keys
     * @param array $values
     *
     * @return array
     */
    public function combineArrays(array $keys, array $values)
    {
        return array_combine($keys, $this->resizeArray($values, count($keys)));
    }

    /**
     * Resizes an array to the specified data count
     *
     * @param array $data
     * @param int   $count
     *
     * @return array
     */
    protected function resizeArray(array $data, $count)
    {
        if (count($data) < $count) {
            $data = array_merge($data, array_fill(0, $count - count($data), ''));
        }

        return array_slice($data, 0, $count);
    }

    /**
     * Strips empty values from the end of an array
     * 
     * @param array $values
     * 
     * @return array
     */
    protected function trimArray(array $values)
    {
        while (count($values) && '' === trim($values[count($values) - 1])) {
            unset($values[count($values) - 1]);
        }

        return $values;
    }
}
