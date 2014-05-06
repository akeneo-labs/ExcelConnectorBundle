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

    public function it_returns_a_worksheet_list(Relationships $relationships)
    {
        $relationships->getWorksheetPath(\Prophecy\Argument::type('string'))->will(
            function ($args) {
                return 'file_' . $args[0];
            }
        );
        $this->getWorksheets($relationships, __DIR__ . '/../../fixtures/sheet.xml')->shouldReturn(
            [
                'file_rId2' => 'Worksheet1',
                'file_rId3' => 'Worksheet2',
                'file_rId4' => 'Worksheet3',
            ]
        );
    }
}
