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
    protected function createValuesIterator()
    {
        return new \ArrayIterator(array($this->getFamilyData()));
    }

    /**
     * {@inheritdoc}
     */
    protected function getFamilyData()
    {
        $helper = $this->getExcelHelper();
        $xls = $this->getExcelObject();
        $this->attributeLabels = $helper->getRowDataForRowNumber($xls, $this->options['attribute_label_row']);
        $codeRow = $helper->getRowDataForRowNumber($xls, $this->options['code_row']);

        return array(
            'code'               => $codeRow[$this->options['code_column']],
            'attribute_as_label' => $this->getAttributeAsLabel(),
            'labels'             => $this->getLabels(),
            'attributes'         => $this->getAttributes(),
            'requirements'       => $this->getRequirements()
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
     * @return string[]
     */
    protected function getLabels()
    {
        $helper = $this->getExcelHelper();
        $xls = $this->getExcelObject();
        $labels = $helper->getRowDataForRowNumber(
            $xls,
            $this->options['labels_label_row'],
            $this->options['labels_column']
        );
        $values = $helper->getRowDataForRowNumber(
            $xls,
            $this->options['labels_data_row'],
            $this->options['labels_column']
        );

        return $helper->combineArrays($labels, $values);
    }

    /**
     * Returns an array of attribute codes
     *
     * @return string[]
     */
    protected function getAttributes()
    {
        $attributes = array();
        $codeColumn = array_search('code', $this->attributeLabels);
        foreach ($this->getAttributeRowIterator() as $row) {
            $attributes[] = $row[$codeColumn];
        }

        return $attributes;
    }

    /**
     * Returns an array of attribute requirements
     *
     * @return string[][]
     */
    protected function getRequirements()
    {
        $startColumn = count($this->attributeLabels);
        $helper = $this->getExcelHelper();
        $xls = $this->getExcelObject();

        $families = $helper->getRowDataForRowNumber($xls, $this->options['family_label_row'], $startColumn);
        $requirements = array_fill_keys($families, array());
        $codeColumn = array_search('code', $this->attributeLabels);

        $rowIterator = $helper->createRowIterator($xls, $this->options['attribute_data_row']);
        foreach ($rowIterator as $row) {
            $code = trim($row[$codeColumn]);
            foreach ($families as $index => $family) {
                $value = isset($row[$startColumn + $index]) ? trim($row[$startColumn + $index]) : null;
                if ('1' === $value) {
                    $requirements[$family][] = $code;
                }
            }
        }

        return $requirements;
    }

    /**
     * Returns the code of the attribute used as label for the family
     *
     * @return string
     */
    protected function getAttributeAsLabel()
    {
        $codeColumn = array_search('code', $this->attributeLabels);
        $useAsLabelColumn = array_search('use_as_label', $this->attributeLabels);
        foreach ($this->getAttributeRowIterator() as $row) {
            $useAsLabel = isset($row[$useAsLabelColumn]) ? trim($row[$useAsLabelColumn]) : null;
            if ('1' === $useAsLabel) {
                return trim($row[$codeColumn]);
            }
        }

        return '';
    }

    /**
     * Returns a row iterator for attributes
     *
     * @return \CallbackFilterIterator
     */
    protected function getAttributeRowIterator()
    {
        $xls = $this->getExcelObject();
        $helper = $this->getExcelHelper();

        $codeColumn = array_search('code', $this->attributeLabels);
        $rowIterator = new \CallbackFilterIterator(
            $helper->createRowIterator($xls, $this->options['attribute_data_row']),
            function ($row) use ($codeColumn) {
                $code = isset($row[$codeColumn]) ? trim($row[$codeColumn]) : null;

                return !empty($code);
            }
        );
        $rowIterator->rewind();

        return $rowIterator;
    }
}
