<?php

namespace Pim\Bundle\ExcelConnectorBundle\Iterator;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * XSLX file iterator
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class XlsxFileIterator extends AbstractXlsxFileIterator
{
    /**
     * @var array
     */
    protected $labels;

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        $helper = $this->getExcelHelper();
        $values = $helper->combineArrays(
            $this->labels,
            $helper->getRowData($this->valuesIterator->current())
        );

        if ($this->options['skip_empty']) {
            foreach (array_keys($values) as $key) {
                if (!$values[$key]) {
                    unset($values[$key]);
                }
            }
        }

        return $values;
    }

    /**
     * {@inheritdoc}
     */
    protected function createValuesIterator()
    {
        $helper = $this->getExcelHelper();
        $iterator = $helper->createRowIterator($this->getExcelObject());
        $iterator->rewind();
        while ($iterator->valid() && ((int) $this->options['label_row'] > $iterator->key())) {
            $iterator->next();
        }
        $this->labels = $helper->getRowData($iterator->current());
        while ($iterator->valid() && ((int) $this->options['data_row'] > $iterator->key())) {
            $iterator->next();
        }

        return $iterator;
    }

    /**
     * {@inheritdoc}
     */
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(
            array(
                'skip_empty' => false,
                'label_row'  => 1,
                'data_row'   => 2
            )
        );
    }
}
