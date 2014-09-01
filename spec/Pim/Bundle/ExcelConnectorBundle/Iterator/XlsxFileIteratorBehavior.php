<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Iterator;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Iterator\ArrayHelper;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\Spreadsheet;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\SpreadsheetLoader;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Common behavior for xlsx file iterator specs
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class XlsxFileIteratorBehavior extends ObjectBehavior
{
    public function let(
        ContainerInterface $container,
        ArrayHelper $arrayHelper,
        SpreadsheetLoader $spreadsheetReader,
        Spreadsheet $spreadsheet
    ) {
        $spreadsheetReader->open('path')->willReturn($spreadsheet);
        $arrayHelper->combineArrays(Argument::type('array'), Argument::type('array'))->will(
            function ($args) {
                return array_combine($args[0], $args[1]);
            }
        );
        $container->get('pim_excel_connector.iterator.array_helper')->willReturn($arrayHelper);
        $container->get('akeneo_spreadsheet_parser.spreadsheet_loader')->willReturn($spreadsheetReader);
    }
}
