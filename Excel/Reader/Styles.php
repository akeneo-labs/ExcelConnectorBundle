<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

/**
 * Workbook styles
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Styles
{
    /**
     * Constructor
     *
     * @param string $stylesPath the path to the XML styles file
     */
    public function __construct($path)
    {
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * Returns a format by id
     *
     * @param string $id
     *
     * @return string
     */
    public function get($id)
    {
        throw new \Exception('NOT IMPLEMENTED');
    }
}
