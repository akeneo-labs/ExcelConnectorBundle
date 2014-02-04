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
        return array_combine(
            $this->labels,
            $this->resizeArray($this->getRowData($this->valuesIterator->current()), count($this->labels))
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function createValuesIterator(\PHPExcel_Worksheet $worksheet)
    {
        $this->labels = $this->getRowDataForRowNumber($worksheet, $this->options['label_row']);

        return $worksheet->getRowIterator($this->options['data_row']);
    }

    /**
     * {@inheritdoc}
     */
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(
            array(
                'label_row' => 1,
                'data_row'  => 1
            )
        );
    }
}
