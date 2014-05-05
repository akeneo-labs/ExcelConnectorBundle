<?php

namespace Pim\Bundle\ExcelConnectorBundle\SpreadsheetReader;

/**
 * ContentCache factory
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ContentCacheReader
{
    /**
     * Constructor
     *
     * @param string $contentCacheClass The class for created objects
     * @param int    $maxCachedElements The max number of elements to be cached
     */
    public function __construct($contentCacheClass, $maxCachedElements)
    {
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * Creates a ContentCache from the archive
     *
     * @param Archive $archive
     *
     * @return ContentCache
     */
    public function read(Archive $archive)
    {
        throw new \Exception('NOT IMPLEMENTED');
    }
}
