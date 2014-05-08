<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\Relationships;

class WorksheetListReaderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Excel\Reader\WorksheetListReader');
    }

    public function it_returns_worksheet_paths(Relationships $relationships)
    {
        $relationships->getWorksheetPath(\Prophecy\Argument::type('string'))->will(
            function ($args) {
                return 'file_' . $args[0];
            }
        );
        $this->getWorksheetPaths($relationships, __DIR__ . '/../../fixtures/sheet.xml')->shouldReturn(
            [
                'Worksheet1' => 'file_rId2',
                'Worksheet2' => 'file_rId3',
                'Worksheet3' => 'file_rId4',
            ]
        );
    }
}
