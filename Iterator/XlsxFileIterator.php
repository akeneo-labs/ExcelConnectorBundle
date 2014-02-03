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
        $data = array_slice($this->getRowData($this->valuesIterator->current()), 0, count($this->labels));
        $data = $data + array_fill(0, count($this->labels) - count($data), '');
        
        return array_combine($this->labels, $data);
    }

    /**
     * {@inheritdoc}
     */
    protected function createValuesIterator(\PHPExcel_Worksheet $worksheet)
    {
        $labelRow = $worksheet->getRowIterator($this->options['label_row'])->current();
        $this->labels = $this->getRowData($labelRow);

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
