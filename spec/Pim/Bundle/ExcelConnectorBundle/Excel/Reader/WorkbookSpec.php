<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\RowIterator;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\Archive;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\ContentCache;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\ContentCacheLoader;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\RowIteratorFactory;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\WorksheetListReader;

class WorkbookSpec extends ObjectBehavior
{
    public function let(
        ContentCacheLoader $contentCacheReader,
        ContentCache $contentCache,
        WorksheetListReader $worksheetListReader,
        RowIteratorFactory $rowIteratorFactory,
        Archive $archive
    ) {
        $this->beConstructedWith($contentCacheReader, $worksheetListReader, $rowIteratorFactory, $archive);
        $contentCacheReader->open($archive)->willReturn($contentCache);
        $worksheetListReader->getWorksheets($archive)->willReturn(['path1' => 'sheet1', 'path2' => 'sheet2']);
        $archive->extract('path1')->willReturn('extracted_path1');
        $archive->extract('path2')->willReturn('extracted_path2');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Excel\Reader\Workbook');
    }

    public function it_returns_the_worksheet_list()
    {
        $this->getWorksheets()->shouldReturn(['sheet1', 'sheet2']);
    }

    public function it_creates_row_iterators(
        ContentCache $contentCache,
        RowIteratorFactory $rowIteratorFactory,
        RowIterator $rowIterator1,
        RowIterator $rowIterator2
    )
    {
        $rowIteratorFactory->create($contentCache, 'extracted_path1')->willReturn($rowIterator1);
        $rowIteratorFactory->create($contentCache, 'extracted_path2')->willReturn($rowIterator2);

        $this->createRowIterator(0)->shouldReturn($rowIterator1);
        $this->createRowIterator(1)->shouldReturn($rowIterator2);
    }

    public function it_finds_a_worksheet_index_by_name()
    {
        $this->getWorksheetIndex('sheet2')->shouldReturn(1);
    }

    public function it_returns_null_if_a_worksheet_does_not_exist()
    {
        $this->getWorksheetIndex('sheet3')->shouldReturn(null);
    }
}
