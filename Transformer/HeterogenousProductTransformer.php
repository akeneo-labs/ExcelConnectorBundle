<?php

namespace Pim\Bundle\ExcelConnectorBundle\Transformer;

use Pim\Bundle\TransformBundle\Transformer\ProductTransformer;

/**
 * Transformer for products based on heterogeneous data
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class HeterogenousProductTransformer extends ProductTransformer
{
    /**
     * @var array
     */
    protected $labels;

    /**
     * {@inheritdoc}
     */
    public function transform($class, array $data, array $defaults = array())
    {
        if ($this->hasNewLabels(array_keys($data))) {
            $this->reset();
        }

        return parent::transform($class, $data, $defaults);
    }

    /**
     * Returns true if labels have changed since the last call
     *
     * @param  array   $labels
     * @return boolean
     */
    protected function hasNewLabels(array $labels)
    {
        if (!isset($this->labels) ||
            count(array_diff($labels, $this->labels)) ||
            count(array_diff($this->labels, $labels))) {
            $this->labels = $labels;

            return true;
        }

        return false;
    }
}
