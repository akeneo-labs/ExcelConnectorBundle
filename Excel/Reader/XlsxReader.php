<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

/**
 * Entry point for XLSX reader
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class XlsxReader
{
    /**
     * @staticvar string Archive class
     */
    const ARCHIVE_CLASS = 'Pim\Bundle\ExcelConnectorBundle\Excel\Reader\Archive';

    /**
     * @staticvar string Relationships class
     */
    const RELATIONSHIPS_CLASS = 'Pim\Bundle\ExcelConnectorBundle\Excel\Reader\Relationships';

    /**
     * @staticvar string RowIterator class
     */
    const ROW_ITERATOR_CLASS = 'Pim\Bundle\ExcelConnectorBundle\Excel\Reader\RowIterator';

    /**
     * @staticvar string SharedStrings class
     */
    const SHARED_STRINGS_CLASS = 'Pim\Bundle\ExcelConnectorBundle\Excel\Reader\SharedStrings';

    /**
     * @staticvar string Styles class
     */
    const STYLES_CLASS = 'Pim\Bundle\ExcelConnectorBundle\Excel\Reader\Styles';

    /**
     * @staticvar string ValueTransformer class
     */
    const VALUE_TRANSFORMER_CLASS = 'Pim\Bundle\ExcelConnectorBundle\Excel\Reader\ValueTransformer';

    /**
     * @staticvar string Workbook class
     */
    const WORKBOOK_CLASS = 'Pim\Bundle\ExcelConnectorBundle\Excel\Reader\Workbook';

    /**
     * @var WorkbookLoader
     */
    private static $workbookLoader;

    /**
     * Opens an XLSX file
     *
     * @param string $path
     *
     * @return Workbook
     */
    public static function open($path)
    {
        return static::getWorkbookLoader()->open($path);
    }

    /**
     * @return WorkbookLoader
     */
    public static function getWorkbookLoader()
    {
        if (!isset(self::$workbookLoader)) {
            self::$workbookLoader = new WorkbookLoader(
                $this->createArchiveLoader(),
                $this->createRelationshipsLoader(),
                $this->createStylesLoader(),
                $this->createWorksheetListReader(),
                $this->createValueTransformerFactory(),
                $this->createRowIteratorFactory(),
                static::WORKBOOK_CLASS
            );
        }

        return self::$workbookLoader;
    }

    /**
     * @return ArchiveLoader
     */
    protected static function createArchiveLoader()
    {
        return new ArchiveLoader(static::ARCHIVE_CLASS);
    }

    /**
     * @return RelationshipsLoader
     */
    protected function createRelationshipsLoader()
    {
        return new RelationshipsLoader(static::RELATIONSHIPS_CLASS);
    }

    /**
     * @return SharedStringsLoader
     */
    protected static function createSharedStringsLoader()
    {
        return new SharedStringsLoader(static::SHARED_STRINGS_CLASS);
    }

    /**
     * @return StylesLoader
     */
    protected static function createStylesLoader()
    {
        return new StylesLoader(static::STYLES_CLASS);
    }

    /**
     * @return WorksheetListReader
     */
    protected static function createWorksheetListReader()
    {
        return new WorksheetListReader();
    }

    /**
     * @return ValueTransformerFactory
     */
    protected static function createValueTransformerFactory()
    {
        return new ValueTransformerFactory($this->createDateTransformer(), static::VALUE_TRANSFORMER_CLASS);
    }

    /**
     * @return DateTransformer
     */
    protected static function createDateTransformer()
    {
        return new DateTransformer();
    }

    /**
     * @return RowIteratorFactory
     */
    protected static function createRowIteratorFactory()
    {
        return new RowIteratorFactory(static::ROW_ITERATOR_CLASS);
    }
}
