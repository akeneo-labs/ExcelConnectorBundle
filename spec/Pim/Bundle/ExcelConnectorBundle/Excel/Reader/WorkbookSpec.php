<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\Archive;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\Relationships;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\RelationshipsLoader;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\RowIterator;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\RowIteratorFactory;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\SharedStrings;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\SharedStringsLoader;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\ValueTransformer;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\ValueTransformerFactory;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\Workbook;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\WorksheetListReader;
use Prophecy\Argument;

class WorkbookSpec extends ObjectBehavior
{
    public function let(
        RelationshipsLoader $relationshipsLoader,
        SharedStringsLoader $sharedStringsLoader,
        WorksheetListReader $worksheetListReader,
        ValueTransformerFactory $valueTransformerFactory,
        RowIteratorFactory $rowIteratorFactory,
        Archive $archive,
        Relationships $relationships,
        SharedStrings $sharedStrings,
        ValueTransformer $valueTransformer
    ) {
        $this->beConstructedWith(
            $relationshipsLoader,
            $sharedStringsLoader,
            $worksheetListReader,
            $valueTransformerFactory,
            $rowIteratorFactory,
            $archive
        );
        $archive->extract(Argument::type('string'))->will(
            function ($args) {
                return sprintf('temp_%s', $args[0]);
            }
        );

        $relationshipsLoader->open('temp_' . Workbook::RELATIONSHIPS_PATH)
            ->should(
                function () {
                    static $count = 1;
                    $count++;

                    return 1 === $count;
                }
            )
            ->willReturn($relationships);

        $relationships->getSharedStringsPath()->willReturn('shared_strings');
        $sharedStringsLoader->open('temp_shared_strings')
            ->should(
                function () {
                    static $count = 0;

                    return 1 === ++$count;
                }
            )
            ->willReturn($sharedStrings);

        $valueTransformerFactory->create($sharedStrings)->willReturn($valueTransformer);

        $worksheetListReader->getWorksheets($relationships, 'temp_' . Workbook::WORKBOOK_PATH)
            ->should(
                function () {
                    static $count = 0;

                    return 1 === ++$count;
                }
            )
            ->willReturn(['path1' => 'sheet1', 'path2' => 'sheet2']);
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
        ValueTransformer $valueTransformer,
        RowIteratorFactory $rowIteratorFactory,
        RowIterator $rowIterator1,
        RowIterator $rowIterator2
    ) {
        $rowIteratorFactory->create($valueTransformer, 'temp_path1')->willReturn($rowIterator1);
        $rowIteratorFactory->create($valueTransformer, 'temp_path2')->willReturn($rowIterator2);

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
