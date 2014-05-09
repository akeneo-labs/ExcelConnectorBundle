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
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\Styles;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\StylesLoader;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\ValueTransformer;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\ValueTransformerFactory;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\Workbook;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\WorksheetListReader;
use Prophecy\Argument;
use Prophecy\Exception\Prediction\UnexpectedCallsException;

class WorkbookSpec extends ObjectBehavior
{
    public function let(
        RelationshipsLoader $relationshipsLoader,
        SharedStringsLoader $sharedStringsLoader,
        StylesLoader $stylesLoader,
        WorksheetListReader $worksheetListReader,
        ValueTransformerFactory $valueTransformerFactory,
        RowIteratorFactory $rowIteratorFactory,
        Archive $archive,
        Relationships $relationships,
        SharedStrings $sharedStrings,
        ValueTransformer $valueTransformer,
        Styles $styles
    ) {
        $this->beConstructedWith(
            $archive,
            $relationshipsLoader,
            $sharedStringsLoader,
            $stylesLoader,
            $worksheetListReader,
            $valueTransformerFactory,
            $rowIteratorFactory
        );
        $archive->extract(Argument::type('string'))->will(
            function ($args) {
                return sprintf('temp_%s', $args[0]);
            }
        );

        $beCalledAtMostOnce = function ($calls, $object, $method) {
            if (count($calls) > 1) {
                throw new UnexpectedCallsException(
                    'Method should be called at most once',
                    $method,
                    $calls
                );
            }
        };
        $relationshipsLoader->open('temp_' . Workbook::RELATIONSHIPS_PATH)
            ->should($beCalledAtMostOnce)
            ->willReturn($relationships);

        $relationships->getSharedStringsPath()->willReturn('shared_strings');
        $relationships->getStylesPath()->willReturn('styles');

        $sharedStringsLoader->open('temp_shared_strings')
            ->should($beCalledAtMostOnce)
            ->willReturn($sharedStrings);

        $stylesLoader->open(('temp_styles'))->willReturn($styles);
        $valueTransformerFactory->create($sharedStrings, $styles)->willReturn($valueTransformer);

        $worksheetListReader->getWorksheetPaths($relationships, 'temp_' . Workbook::WORKBOOK_PATH)
            ->should($beCalledAtMostOnce)
            ->willReturn(['sheet1' => 'path1', 'sheet2' => 'path2']);
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

    public function it_returns_false_if_a_worksheet_does_not_exist()
    {
        $this->getWorksheetIndex('sheet3')->shouldReturn(false);
    }
}
