<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel;

/**
 * Common interface for excel builder
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
interface ExcelBuilderInterface
{
    /**
     * Adds an item to the Excel file
     *
     * @param array $item
     */
    public function add(array $item);

    /**
     * Returns the excel object
     *
     * @return \PHPExcel
     */
    public function getExcelObject();
}
