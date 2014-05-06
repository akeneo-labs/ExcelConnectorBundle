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
     *
     * @var SharedStringsLoader
     */
    protected $sharedStringsLoader;

    /**
     *
     * @var RowIteratorFactory
     */
    protected $rowIteratorFactory;

    /**
     * @var Archive
     */
    protected $archive;

    /**
     * @var StylesLoader
     */
    protected $stylesLoader;

    /**
     * @var WorksheetListReader
     */
    protected $worksheetListReader;

    /**
     * @var Relationships
     */
    private $relationships;

    /**
     * @var ValueTransformer
     */
    private $valueTransformer;

    /**
     *
     * @var SharedStrings
     */
    private $sharedStrings;

    /**
     * @var array
     */
    private $worksheets;

    /**
     * @var Styles
     */
    private $styles;

    /**
     * Constructor
     *
     * @param RelationshipsLoader     $relationshipsLoader
     * @param SharedStringsLoader     $sharedStringsLoader
     * @param StylesLoader            $stylesLoader
     * @param WorksheetListReader     $worksheetListReader
     * @param ValueTransformerFactory $valueTransformerFactory
     * @param RowIteratorFactory      $rowIteratorFactory
     * @param Archive                 $archive
     */
    public function __construct(
        RelationshipsLoader $relationshipsLoader,
        SharedStringsLoader $sharedStringsLoader,
        StylesLoader $stylesLoader,
        WorksheetListReader $worksheetListReader,
        ValueTransformerFactory $valueTransformerFactory,
        RowIteratorFactory $rowIteratorFactory,
        Archive $archive
    ) {
        $this->relationshipsLoader = $relationshipsLoader;
        $this->sharedStringsLoader = $sharedStringsLoader;
        $this->stylesLoader = $stylesLoader;
        $this->worksheetListReader = $worksheetListReader;
        $this->valueTransformerFactory = $valueTransformerFactory;
        $this->rowIteratorFactory = $rowIteratorFactory;
        $this->archive = $archive;
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
        return array_values($this->getWorksheetPaths());
    }

    /**
     * Returns a row iterator for the current worksheet index
     *
     * @param int $worksheetIndex
     *
     * @return \Iterator
     */
    public function createRowIterator($worksheetIndex)
    {
        $paths = array_keys($this->getWorksheetPaths());

        return $this->rowIteratorFactory->create($this->getValueTransformer(), $this->archive->extract($paths[$worksheetIndex]));
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
        return array_search($name, $this->getWorksheets());
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
            $this->valueTransformer = $this->valueTransformerFactory->create(
                $this->getSharedStrings(),
                $this->getStyles()
            );
        }

        return $this->valueTransformer;
    }

    /**
     * @return SharedStrings
     */
    protected function getSharedStrings()
    {
        if (!$this->sharedStrings) {
            $path = $this->archive->extract($this->relationships->getSharedStringsPath());
            $this->sharedStrings = $this->sharedStringsLoader->open($path);
        }

        return $this->sharedStrings;
    }

    /**
     * @return array
     */
    protected function getWorksheetPaths()
    {
        if (!$this->worksheets) {
            $path = $this->archive->extract(static::WORKBOOK_PATH);
            $this->worksheets = $this->worksheetListReader->getWorksheets($this->getRelationships(), $path);
        }

        return $this->worksheets;
    }

    /**
     * @return Styles
     */
    protected function getStyles()
    {
        if (!$this->styles) {
            $path = $this->archive->extract($this->relationships->getStylesPath());
            $this->styles = $this->stylesLoader->open($path);
        }

        return $this->styles;
    }
}
