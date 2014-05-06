<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

/**
 * Workbook relationships
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Relationships
{
    /**
     * Constructor
     *
     * @param string $relationshipsPath the path to the XML relationships file
     */
    public function __construct($relationshipsPath)
    {
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * Returns the path of a worksheet file inside the xlsx file
     *
     * @param string $id
     *
     * @return string
     */
    public function getWorksheetPath($id)
    {
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * Returns the path of the shared strings file inside the xlsx file
     *
     * @return string
     */
    public function getSharedStringsPath()
    {
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * Returns the path of the styles XML file inside the xlsx file
     *
     * @return string
     */
    public function getStylesPath()
    {
        throw new \Exception('NOT IMPLEMENTED');
    }
}
