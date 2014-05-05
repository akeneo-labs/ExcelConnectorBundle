<?php

namespace Pim\Bundle\ExcelConnectorBundle\SpreadsheetReader;

/**
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
     * The keys of the array should be the name of the worksheety XML files inside the archive
     * The values of the array should be the titles of the worksheets
     *
     * @param Archive $archive
     */
    public function read(Archive $archive)
    {
        throw new  \Exception('NOT IMPLEMENTED');
    }
}
