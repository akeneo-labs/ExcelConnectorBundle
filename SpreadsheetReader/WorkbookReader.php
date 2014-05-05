<?php

namespace Pim\Bundle\ExcelConnectorBundle\SpreadsheetReader;

/**
 * XLSX file reader
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class WorkbookReader
{
    /**
     * Constructor
     *
     * @param ArchiveReader       $archiveReader
     * @param ContentCacheReader  $contentCacheReader
     * @param WorksheetListReader $worksheetListReader
     * @param RowIteratorFactory  $rowIteratorFactory
     * @param string              $workbookClass
     */
    public function __construct(
        ArchiveReader $archiveReader,
        ContentCacheReader $contentCacheReader,
        WorksheetListReader $worksheetListReader,
        RowIteratorFactory $rowIteratorFactory,
        $workbookClass
    ) {
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * Opens an xlsx workbook
     *
     * @param string $path
     *
     * @return Workbook
     */
    public function open($path)
    {
        throw new \Exception('NOT IMPLEMENTED');
    }
}
