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
     *
     * @var array
     */
    protected $values = array();

    /**
     * Adds a value to the row
     *
     * @param int    $columnIndex
     * @param string $value
     */
    public function addValue($columnIndex, $value)
    {

        for ($i = 0; $i <= $columnIndex; $i++) {
            if (!array_key_exists($i, $this->values)) {
                $this->values[$i] = '';
            }
        }
        $this->values[$columnIndex] = $value;
    }

    /**
     * Returns the read row
     *
     * @return array
     */
    public function getData()
    {
        $arrayTemp = array_reverse($this->values, true);

        foreach ($arrayTemp as $key => $value) {

            if ('' === $value) {
                unset($arrayTemp[$key]);
            } else {
                break;
            }
        }

        return array_reverse($arrayTemp);
    }

}
