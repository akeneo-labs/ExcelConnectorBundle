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
     * Creates a row iterator
     *
     * @param \Iterator $worksheet
     *
     * @return \Iterator
     */
    public function createRowIterator(\Iterator $worksheet)
    {
        return new RowIterator($this, $worksheet);
    }

    /**
     * Returns an array of values for a row
     *
     * @param array $row
     * @param int   $startColumn
     *
     * @return array
     */
    public function getRowData(array $row, $startColumn = 0)
    {
        if ($startColumn > 0) {
            array_splice($row, 0, $startColumn);
        }

        return $this->trimArray($row);
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
