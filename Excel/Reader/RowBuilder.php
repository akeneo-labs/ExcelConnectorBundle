<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

/**
 * Builds a row with skipped values
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class RowBuilder
{
    /**
     * Adds a value to the row
     *
     * @param int    $columnIndex
     * @param string $value
     */
    public function addValue($columnIndex, $value)
    {
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * Returns the read row
     *
     * @return array
     */
    public function getData()
    {
        throw new \Exception('NOT IMPLEMENTED');
    }
}
