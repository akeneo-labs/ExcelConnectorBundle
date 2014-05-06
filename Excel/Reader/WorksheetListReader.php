<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

/**
 * Reads the worksheet list from a workbook
 * 
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class WorksheetListReader
{
    /**
     * Returns the list of worksheets inside the archive
     *
     * The keys of the array are the names of the XML worksheet files inside the archive
     * The values of the array should be the titles of the worksheets
     *
     * @param Relationships $relationships
     * @param string        $path
     */
    public function getWorksheets(Relationships $relationships, $path)
    {
        throw new  \Exception('NOT IMPLEMENTED');
    }
}
