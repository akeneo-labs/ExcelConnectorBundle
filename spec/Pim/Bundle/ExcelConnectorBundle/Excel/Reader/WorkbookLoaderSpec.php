<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\Archive;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\ArchiveLoader;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\RelationshipsLoader;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\RowIteratorFactory;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\SharedStringsLoader;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\StylesLoader;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\ValueTransformerFactory;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\WorksheetListReader;

class WorkbookLoaderSpec extends ObjectBehavior
{
    public function let(
        ArchiveLoader $archiveReader,
        RelationshipsLoader $relationshipsLoader,
        SharedStringsLoader $sharedStringsLoader,
        StylesLoader $stylesLoader,
        WorksheetListReader $worksheetListReader,
        ValueTransformerFactory $valueTransformerFactory,
        RowIteratorFactory $rowIteratorFactory
    ) {
        $this->beConstructedWith(
            $archiveReader,
            $relationshipsLoader,
            $sharedStringsLoader,
            $stylesLoader,
            $worksheetListReader,
            $valueTransformerFactory,
            $rowIteratorFactory,
            'spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader\StubWorkbook'
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Excel\Reader\WorkbookLoader');
    }

    public function it_creates_workbook_objects(
        ArchiveLoader $archiveReader,
        RelationshipsLoader $relationshipsLoader,
        SharedStringsLoader $sharedStringsLoader,
        StylesLoader $stylesLoader,
        WorksheetListReader $worksheetListReader,
        ValueTransformerFactory $valueTransformerFactory,
        RowIteratorFactory $rowIteratorFactory,
        Archive $archive
    ) {
        $archiveReader->open('path')->willReturn($archive);

        $workbook = $this->open('path');
        $workbook->getArchive()->shouldReturn($archive);
        $workbook->getSharedStringsLoader()->shouldReturn($sharedStringsLoader);
        $workbook->getStylesLoader()->shouldReturn($stylesLoader);
        $workbook->getRowIteratorFactory()->shouldReturn($rowIteratorFactory);
        $workbook->getWorksheetListReader()->shouldReturn($worksheetListReader);
        $workbook->getValueTransformerFactory()->shouldReturn($valueTransformerFactory);
        $workbook->getRelationshpsLoader()->shouldReturn($relationshipsLoader);
    }

    public function it_caches_workbook_objects(
        ArchiveLoader $archiveReader,
        Archive $archive
    ) {
        $archiveReader->open('path')->shouldBeCalledTimes(1)->willReturn($archive);

        $workbook = $this->open('path');
        $workbook->getArchive()->shouldReturn($archive);
        $workbook->getArchive()->shouldReturn($archive);
    }
}

class StubWorkbook
{
    protected $sharedStringsLoader;
    protected $worksheetListReader;
    protected $relationshipsLoader;
    protected $stylesLoader;
    protected $rowIteratorFactory;
    protected $valueTransformerFactory;
    protected $archive;

    public function __construct(
        SharedStringsLoader $sharedStringsLoader,
        RelationshipsLoader $relationshipsLoader,
        StylesLoader $stylesLoader,
        WorksheetListReader $worksheetListReader,
        ValueTransformerFactory $valueTransformerFactory,
        RowIteratorFactory $rowIteratorFactory,
        Archive $archive
    ) {
        $this->sharedStringsLoader = $sharedStringsLoader;
        $this->relationshipsLoader = $relationshipsLoader;
        $this->stylesLoader = $stylesLoader;
        $this->worksheetListReader = $worksheetListReader;
        $this->valueTransformerFactory = $valueTransformerFactory;
        $this->rowIteratorFactory = $rowIteratorFactory;
        $this->archive = $archive;
    }

    public function getSharedStringsLoader()
    {
        return $this->sharedStringsLoader;
    }

    public function getRowIteratorFactory()
    {
        return $this->rowIteratorFactory;
    }

    public function getArchive()
    {
        return $this->archive;
    }

    public function getWorksheetListReader()
    {
        return $this->worksheetListReader;
    }

    public function getRelationshipsLoader()
    {
        return $this->relationshipsLoader;
    }

    public function getValueTransformerFactory()
    {
        return $this->valueTransformerFactory;
    }

    public function getStylesLoader()
    {
        return $this->stylesLoader;
    }
}
