<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

/**
 * XLSX file reader
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class WorkbookLoader
{
    /**
     * Constructor
     *
     * @param ArchiveLoader           $archiveReader
     * @param RelationshipsLoader     $relationshipsLoader
     * @param SharedStringsLoader     $sharedStringsLoader
     * @param WorksheetListReader     $worksheetListReader
     * @param ValueTransformerFactory $valueTransformerFactory
     * @param RowIteratorFactory      $rowIteratorFactory
     * @param string                  $workbookClass
     */
    public function __construct(
        ArchiveLoader $archiveReader,
        RelationshipsLoader $relationshipsLoader,
        SharedStringsLoader $sharedStringsLoader,
        WorksheetListReader $worksheetListReader,
        ValueTransformerFactory $valueTransformerFactory,
        RowIteratorFactory $rowIteratorFactory,
        $workbookClass
    ) {
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * Opens an xlsx workbook and returns a Workbook object
     *
     * Workbook objects are cached, and will be read only once
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
