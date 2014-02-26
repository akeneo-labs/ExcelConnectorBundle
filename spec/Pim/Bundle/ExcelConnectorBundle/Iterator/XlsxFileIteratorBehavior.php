<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Iterator;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Excel\ExcelHelper;
use Pim\Bundle\ExcelConnectorBundle\Excel\ObjectCache;
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
    public function let(ContainerInterface $container)
    {
        $helper = new ExcelHelper;
        $container->get('pim_excel_connector.excel.helper')->willReturn($helper);
        $container->get('pim_excel_connector.excel.object_cache')->willReturn(new ObjectCache());
    }
}
