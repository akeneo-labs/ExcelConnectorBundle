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
        $this->attributeLabels = $this->getRowDataForRowNumber($worksheet, $this->options['attribute_label_row']);

        return array(
            'code'               => $worksheet->getCellByColumnAndRow(
                $this->options['code_column'],
                $this->options['code_row']
            )->getValue(),
            'attribute_as_label' => $this->getAttributeAsLabel($worksheet),
            'labels'             => $this->getLabels($worksheet),
            'attributes'         => $this->getAttributes($worksheet),
            'requirements'       => $this->getRequirements($worksheet)
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setRequired(
            array(
                'family_label_row',
                'attribute_label_row',
                'attribute_data_row',
                'code_row',
                'code_column',
                'labels_column',
                'labels_label_row',
                'labels_data_row',
                'labels_column'
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
        $labels = $this->getRowDataForRowNumber(
            $worksheet,
            $this->options['labels_label_row'],
            $this->options['labels_column']
        );
        $values = $this->getRowDataForRowNumber(
            $worksheet,
            $this->options['labels_data_row'],
            $this->options['labels_column']
        );

        return $this->combineArrays($labels, $values);
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
        $attributes = array();
        $codeColumn = array_search('code', $this->attributeLabels);
        foreach ($this->getAttributeRowIterator($worksheet) as $row) {
            $attributes[] = trim($worksheet->getCellByColumnAndRow($codeColumn, $row->getRowIndex())->getValue());
        }
        
        return $attributes;
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
        $startColumn = count($this->attributeLabels);
        $families = $this->getRowDataForRowNumber($worksheet, $this->options['family_label_row'], $startColumn);
        $requirements = array_fill_keys($families, array());
        $codeColumn = array_search('code', $this->attributeLabels);
        
        $rowIterator = $worksheet->getRowIterator($this->options['attribute_data_row']);
        foreach ($rowIterator as $row) {
            $code = trim($worksheet->getCellByColumnAndRow($codeColumn, $row->getRowIndex())->getValue());
            foreach ($families as $index => $family) {
                $value = $worksheet->getCellByColumnAndRow($startColumn + $index, $row->getRowIndex());
                if ('1' === trim($value)) {
                    $requirements[$family][] = $code;
                }
            }
        }
        
        return $requirements;
    }

    /**
     * Returns the code of the attribute used as label for the family
     * 
     * @param \PHPExcel_Worksheet $worsheet
     * 
     * @return string
     */
    protected function getAttributeAsLabel(\PHPExcel_Worksheet $worksheet)
    {
        $codeColumn = array_search('code', $this->attributeLabels);
        $useAsLabelColumn = array_search('use_as_label', $this->attributeLabels);
        foreach ($this->getAttributeRowIterator($worksheet) as $row) {
            $useAsLabel = trim($worksheet->getCellByColumnAndRow($useAsLabelColumn, $row->getRowIndex())->getValue());
            if ('1' === $useAsLabel) {
                return trim($worksheet->getCellByColumnAndRow($codeColumn, $row->getRowIndex())->getValue());
            }
        }

        return '';
    }

    /**
     * Returns a row iterator for attributes
     * 
     * @param \PHPExcel_Worksheet $worksheet
     * @return \CallbackFilterIterator
     */
    protected function getAttributeRowIterator(\PHPExcel_Worksheet $worksheet)
    {
        $codeColumn = array_search('code', $this->attributeLabels);
        $rowIterator = new \CallbackFilterIterator(
            $worksheet->getRowIterator($this->options['attribute_data_row']),
            function($row) use ($worksheet, $codeColumn) {
                $code = trim($worksheet->getCellByColumnAndRow($codeColumn, $row->getRowIndex())->getValue());
                return !empty($code);
            }
        );
        $rowIterator->rewind();
        
        return $rowIterator;
    }
}
