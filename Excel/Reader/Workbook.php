<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

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
     * @staticvar string Path to the relationships file inside the XLSX archive
     */
    const RELATIONSHIPS_PATH = 'xl/_rels/workbook.xml.rels';

    /**
     * @staticvar string Path to the workbooks file inside the XLSX archive
     */
    const WORKBOOK_PATH = 'xl/workbook.xml';

    /**
     * @var RelationshipsLoader  
     */
    protected $relationshipsLoader;

    /**
     * @var ValueTransformerFactory
     */
    protected $valueTransformerFactory;

    /**
     * @var Archive
     */
    protected $archive;

    /**
     * @var Relationships
     */
    private $relationships;

    /**
     * @var ValueTransformer
     */
    private $valueTransformer;

    /**
     * Constructor
     *
     * @param RelationshipsLoader     $relationshipsLoader
     * @param SharedStringsLoader     $sharedStringsLoader
     * @param WorksheetListReader     $worksheetListReader
     * @param ValueTransformerFactory $valueTransformerFactory
     * @param RowIteratorFactory      $rowIteratorFactory
     * @param Archive                 $archive
     */
    public function __construct(
        RelationshipsLoader $relationshipsLoader,
        SharedStringsLoader $sharedStringsLoader,
        WorksheetListReader $worksheetListReader,
        ValueTransformerFactory $valueTransformerFactory,
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
     * @param int $worksheetIndex
     *
     * @return \Iterator
     */
    public function createRowIterator($worksheetIndex)
    {
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * Returns a worksheet index by name
     *
     * @param string $name
     *
     * @return int
     */
    public function getWorksheetIndex($name)
    {
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * @return Relationships
     */
    protected function getRelationships()
    {
        if (!$this->relationships) {
            $path = $this->archive->extract(static::RELATIONSHIPS_PATH);
            $this->relationships = $this->relationshipsLoader->open($path);
        }
        return $this->relationships;
    }

    /**
     * @return ValueTransformer
     */
    protected function getValueTransformer()
    {
        if (!$this->valueTransformer) {
            $this->valueTransformer = $this->valueTransformerFactory->create($this->getSharedStrings());
        }

        return $this->valueTransformer;
    }
}
