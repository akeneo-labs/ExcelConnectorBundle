<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Iterator;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Iterator\ArrayHelper;
use Pim\Bundle\ExcelConnectorBundle\SpreadsheetReader\Workbook;
use Pim\Bundle\ExcelConnectorBundle\SpreadsheetReader\WorkbookReader;
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
        WorkbookReader $workbookReader,
        Workbook $workbook
    ) {
        $workbookReader->open('path')->willReturn($workbook);
        $arrayHelper->combineArrays(Argument::type('array'), Argument::type('array'))->will(
            function ($args) {
                return array_combine($args[0], $args[1]);
            }
        );
        $container->get('pim_excel_connector.iterator.array_helper')->willReturn($arrayHelper);
        $container->get('pim_excel_connector.spreadsheet_reader.workbook_reader')->willReturn($workbookReader);
    }
}
