<?php

namespace Pim\Bundle\ExcelConnectorBundle\Transformer\Property;

use Pim\Bundle\TransformBundle\Transformer\ColumnInfo\ColumnInfoInterface;
use Pim\Bundle\TransformBundle\Transformer\Property\DefaultTransformer;
use Pim\Bundle\TransformBundle\Transformer\Property\EntityUpdaterInterface;

/**
 * Conversion units transformer
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ConversionUnitsTransformer extends DefaultTransformer implements EntityUpdaterInterface
{
    /**
     * {@inheritdoc}
     */
    public function setValue($object, ColumnInfoInterface $columnInfo, $data, array $options = array())
    {
        $suffixes = $columnInfo->getSuffixes();
        $member = array_pop($suffixes);
        $value = $object->getConversionUnits();
        $value[$member] = $data;
        $object->setConversionUnits($value);
    }
}
