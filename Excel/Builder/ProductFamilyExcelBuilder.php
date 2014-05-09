<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Builder;

/**
 * Excel builder for products, with one tab per family
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ProductFamilyExcelBuilder extends AbstractExcelBuilder
{
    /**
     * {@inheritdoc}
     */
    protected function getWorksheetName(array $data)
    {
        return $data['family'];
    }
}
