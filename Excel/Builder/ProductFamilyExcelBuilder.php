<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Builder;

use PHPExcel_Shared_String;

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
        $worksheetName = $data['family'];
        if (PHPExcel_Shared_String::CountCharacters($worksheetName) > 31) {
            $worksheetName = PHPExcel_Shared_String::Substring($worksheetName, 0, 31);
        }
        return $worksheetName;
    }
}
