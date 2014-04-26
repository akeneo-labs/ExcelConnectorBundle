<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel;

/**
 * Excel object cache
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ObjectCache
{
    /**
     * @var \PHPExcel[]
     */
    protected $cache = array();

    /**
     * Load an Excel file
     *
     * @param string $filePath
     */
    public function load($filePath)
    {
        if (!isset($this->cache[$filePath])) {
            $reader = new \SpreadsheetReader_XLSX($filePath);
            $this->cache[$filePath] =  $reader;
        }

        return $this->cache[$filePath];
    }
}
