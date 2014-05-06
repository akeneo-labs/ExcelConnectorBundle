<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RelationshipsSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(__DIR__ . '/../../fixtures/workbook.xml.rels');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Excel\Reader\Relationships');
    }

    function it_returns_worksheet_paths()
    {
        $this->getWorksheetPath('rId2')->shouldReturn('xl/worksheets/sheet2.xml');
        $this->getWorksheetPath('rId3')->shouldReturn('xl/worksheets/sheet3.xml');
        $this->getWorksheetPath('rId4')->shouldReturn('xl/worksheets/sheet4.xml');
    }

    function it_returns_shared_strings_path()
    {
        $this->getSharedStringsPath()->shouldReturn('xl/sharedStrings.xml');
    }
}
