<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\SpreadsheetReader;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\SpreadsheetReader\Archive;
use Pim\Bundle\ExcelConnectorBundle\SpreadsheetReader\ArchiveReader;
use Pim\Bundle\ExcelConnectorBundle\SpreadsheetReader\ContentCacheReader;
use Pim\Bundle\ExcelConnectorBundle\SpreadsheetReader\RowIteratorFactory;
use Pim\Bundle\ExcelConnectorBundle\SpreadsheetReader\WorksheetListReader;

class WorkbookReaderSpec extends ObjectBehavior
{
    public function let(
        ArchiveReader $archiveReader,
        ContentCacheReader $contentCacheReader,
        WorksheetListReader $worksheetListReader,
        RowIteratorFactory $rowIteratorFactory
    ) {
        $this->beConstructedWith(
            $archiveReader,
            $contentCacheReader,
            $worksheetListReader,
            $rowIteratorFactory,
            'spec\Pim\Bundle\ExcelConnectorBundle\SpreadsheetReader\StubWorkbook'
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\SpreadsheetReader\WorkbookReader');
    }

    public function it_creates_workbook_objects(
        ArchiveReader $archiveReader,
        ContentCacheReader $contentCacheReader,
        WorksheetListReader $worksheetListReader,
        RowIteratorFactory $rowIteratorFactory,
        Archive $archive
    ) {
        $archiveReader->open('path')->willReturn($archive);

        $workbook = $this->open('path');
        $workbook->getArchive()->shouldReturn($archive);
        $workbook->getContentCacheReader()->shouldReturn($contentCacheReader);
        $workbook->getRowIteratorFactory()->shouldReturn($rowIteratorFactory);
        $workbook->getWorksheetListReader()->shouldReturn($worksheetListReader);
    }
}

class StubWorkbook
{
    protected $contentCacheReader;
    protected $worksheetListReader;
    protected $rowIteratorFactory;
    protected $archive;

    public function __construct(
        ContentCacheReader $contentCacheReader,
        WorksheetListReader $worksheetListReader,
        RowIteratorFactory $rowIteratorFactory,
        Archive $archive
    ) {
        $this->contentCacheReader = $contentCacheReader;
        $this->worksheetListReader = $worksheetListReader;
        $this->rowIteratorFactory = $rowIteratorFactory;
        $this->archive = $archive;
    }

    public function getContentCacheReader()
    {
        return $this->contentCacheReader;
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
}
