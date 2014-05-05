<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

/**
 * ContentCache factory
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ContentCacheLoader
{
    /**
     * Constructor
     *
     * @param string $contentCacheClass The class for created objects
     */
    public function __construct($contentCacheClass)
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
    public function open(Archive $archive)
    {
        throw new \Exception('NOT IMPLEMENTED');
    }
}
