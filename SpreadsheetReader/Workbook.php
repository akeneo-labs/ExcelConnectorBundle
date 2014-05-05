<?php

namespace Pim\Bundle\ExcelConnectorBundle\SpreadsheetReader;

/**
 * Represents an XLSX workbook
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Workbook
{
    /**
     * Constructor
     *
     * @param ContentCacheReader  $contentCacheReader
     * @param WorksheetListReader $worksheetListReader
     * @param RowIteratorFactory  $rowIteratorFactory
     * @param Archive             $archive
     */
    public function __construct(
        ContentCacheReader $contentCacheReader,
        WorksheetListReader $worksheetListReader,
        RowIteratorFactory $rowIteratorFactory,
        Archive $archive
    ) {
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * Returns an array containing all worksheet names
     *
     * The keys of the array should be the indexes of the worksheets
     *
     * @return array
     */
    public function getWorksheets()
    {
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * Returns a row iterator for the current workseet index
     *
     * @param int $worksheerIndex
     *
     * @return \Iterator
     */
    public function createRowIterator($worksheetIndex)
    {
        throw new \Exception('NOT IMPLEMENTED');
    }
}
