<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;

class RelationshipsSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(__DIR__ . '/../../fixtures/workbook.xml.rels');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Excel\Reader\Relationships');
    }

    public function it_returns_worksheet_paths()
    {
        $this->getWorksheetPath('rId2')->shouldReturn('worksheets/sheet1.xml');
        $this->getWorksheetPath('rId3')->shouldReturn('worksheets/sheet2.xml');
        $this->getWorksheetPath('rId4')->shouldReturn('worksheets/sheet3.xml');
    }

    public function it_returns_shared_strings_path()
    {
        $this->getSharedStringsPath()->shouldReturn('sharedStrings.xml');
    }

    public function it_returns_styles_path()
    {
        $this->getStylesPath()->shouldReturn('styles.xml');
    }
}
