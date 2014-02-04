<?php

namespace Pim\Bundle\ExcelConnectorBundle\Iterator;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Family Xls File Iterator
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class FamilyXlsxFileIterator extends AbstractXlsxFileIterator
{
    /**
     * @var string[]
     */
    protected $attributeLabels;

    /**
     *  {@inheritdoc}
     */
    protected function createValuesIterator(\PHPExcel_Worksheet $worksheet)
    {
        return new \ArrayIterator(array($this->getFamilyData($worksheet)));
    }

    /**
     * {@inheritdoc}
     */
    protected function getFamilyData(\PHPExcel_Worksheet $worksheet)
    {
        $this->attributeLabels;

        return array(
            'code'         => $worksheet->getCellByColumnAndRow($this->options['code_column'], $this->options['code_row']),
            'labels'       => $this->getLabels($worksheet),
            'attributes'   => $this->getAttributes($worksheet),
            'requirements' => $this->getRequirements($worksheet)
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(
            array(
                'attribute_label_row',
                'attribute_data_row',
                'code_column',
                'code_row',
                'labels_column',
                'labels_label_row',
                'labels_data_row'
            )
        );
    }

    /**
     * Returns the labels of the family
     *
     * @param \PHPExcel_Worksheet $worksheet
     *
     * @return string[]
     */
    protected function getLabels(\PHPExcel_Worksheet $worksheet)
    {
        $rowIterator = $worksheet->getRowIterator($this->options['labels_row']);
        $labels = $this->getRowData($rowIterator->current(), $this->options['labels_column']);
        $rowIterator->next();
        $values = $this->resizeArray($this->getRowData($rowIterator->current()), count($labels));

        return array_combine($labels, $values);
    }

    /**
     * Returns an array of attribute codes
     *
     * @param \PHPExcel_Worksheet $worksheet
     *
     * @return string[]
     */
    protected function getAttributes(\PHPExcel_Worksheet $worksheet)
    {
        return array();
    }

    /**
     * Returns an array of attribute requirements
     *
     * @param \PHPExcel_Worksheet $worksheet
     *
     * @return string[][]
     */
    protected function getRequirements(\PHPExcel_Worksheet $worksheet)
    {
        return array();
    }
}
