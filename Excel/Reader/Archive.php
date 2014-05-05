<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

/**
 * Represents an XLSX Archive
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Archive
{
    /**
     * Constructor
     *
     * @param string $archivePath
     */
    public function __construct($archivePath)
    {
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * Extracts the specified file to a temp path, and return the temp path
     *
     * Files are only extracted once for the given archive
     *
     * @param string $filePath
     *
     * @return string
     */
    public function extract($filePath)
    {
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * Clears all extracted files
     */
    public function __destruct()
    {
    }
}
