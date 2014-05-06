<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

/**
 * Contains the shared strings of an Excel workbook
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class SharedStrings
{
    /**
     * Constructor
     *
     * @param string $path path to the extracted shared strings XML file
     */
    public function __construct($path)
    {
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * Returns a shared string by index
     *
     * @param int $index
     */
    public function get($index)
    {
        throw new \Exception('NOT IMPLEMENTED');
    }
}
