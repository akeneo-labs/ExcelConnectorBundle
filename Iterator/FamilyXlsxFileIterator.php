<?php

namespace Pim\Bundle\ExcelConnectorBundle\Iterator;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Channel Xls File Iterator
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class FamilyXlsxFileIterator extends AbstractXlsxFileIterator
{
    /**
     *  {@inheritdoc}
     */
    protected function createValuesIterator()
    {
        return new \ArrayIterator(array($this->getChannelData()));
    }

    /**
     * {@inheritdoc}
     */
    protected function getChannelData()
    {
        $helper = $this->getExcelHelper();
        $xls = $this->getExcelObject();
        $data = [ 'attributes' => [] ];
        $attributeLabels = [];
        $channelLabels = [];
        $labelLocales = [];
        $codeColumn = null;
        $useAsLabelColumn = null;
        $channelColumn = null;
        foreach ($helper->createRowIterator($xls) as $index => $row) {
            if ($index == $this->options['code_row']) {
                $data['code'] = $row[$this->options['code_column']];
            }
            if ($index == $this->options['attribute_label_row']) {
                $attributeLabels = $helper->getRowData($row);
                $channelColumn = count($attributeLabels);
                array_splice($channelLabels, 0, $channelColumn);
                $data['requirements'] = array_fill_keys($channelLabels, []);
                $codeColumn = array_search('code', $attributeLabels);
                $useAsLabelColumn = array_search('use_as_label', $attributeLabels);
            }
            if ($index == $this->options['channel_label_row']) {
                $channelLabels = $helper->getRowData($row);
            }
            if ($index == $this->options['labels_label_row']) {
                $labelLocales = $helper->getRowData($row, $this->options['labels_column']);
            }
            if ($index == $this->options['labels_data_row']) {
                $data['labels'] = $helper->combineArrays(
                    $labelLocales,
                    $helper->getRowData($row, $this->options['labels_column'])
                );
            }
            if ($index >= (int) $this->options['attribute_data_row']) {
                $code = $row[$codeColumn];
                $data['attributes'][] = $code;
                if (isset($row[$useAsLabelColumn]) && ('1' === trim($row[$useAsLabelColumn]))) {
                    $data['attribute_as_label'] = $code;
                }
                $channelValues = $helper->getRowData($row, $channelColumn);
                foreach ($channelLabels as $index => $channel) {
                    if (isset($channelValues[$index]) && '1' === trim($channelValues[$index])) {
                        $data['requirements'][$channel][] = $code;
                    }
                }
            }
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setRequired(
            array(
                'channel_label_row',
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
}
