<?php

namespace Pim\Bundle\ExcelConnectorBundle\Iterator;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Family init file iterator
 *
 * @author    JM leroux <jean-marie.leroux@akeneo.com>
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class InitFamilyFileIterator extends InitFileIterator
{
    /**
     * {@inheritdoc}
     */
    protected function createValuesIterator()
    {
        $familyData = $this->getChannelData();
        $this->headers = array_keys($familyData);
        $this->rows = new \ArrayIterator([$familyData]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getChannelData()
    {
        $this->rows = $this->reader->getSheetIterator()->current()->getRowIterator();

        $data = ['attributes' => []];
        $channelLabels = [];
        $labelLocales = [];
        $codeColumn = null;
        $useAsLabelColumn = null;
        $channelColumn = null;

        $arrayHelper = new ArrayHelper();

        $rowIterator = $this->rows;

        foreach ($rowIterator as $index => $row) {
            $row = $this->trimRight($row);
            if ($index == $this->options['code_row']) {
                $data['code'] = $row[$this->options['code_column']];
            }
            if ($index == $this->options['attribute_label_row']) {
                $attributeLabels = $row;
                $channelColumn = count($attributeLabels);
                array_splice($channelLabels, 0, $channelColumn);
                $data['requirements'] = array_fill_keys($channelLabels, []);
                $codeColumn = array_search('code', $attributeLabels);
                $useAsLabelColumn = array_search('use_as_label', $attributeLabels);
            }
            if ($index == $this->options['channel_label_row']) {
                $channelLabels = $row;
            }
            if ($index == $this->options['labels_label_row']) {
                $labelLocales = array_slice($row, $this->options['labels_column']);
            }
            if ($index == $this->options['labels_data_row']) {
                $data['labels'] = $arrayHelper->combineArrays(
                    $labelLocales,
                    array_slice($row, $this->options['labels_column'])
                );
            }
            if ($index >= (int) $this->options['attribute_data_row']) {
                $code = $row[$codeColumn];
                if ($code === '') {
                    continue;
                }
                $data['attributes'][] = $code;
                if (isset($row[$useAsLabelColumn]) && ('1' === trim($row[$useAsLabelColumn]))) {
                    $data['attribute_as_label'] = $code;
                }
                $channelValues = array_slice($row, $channelColumn);
                foreach ($channelLabels as $channelIndex => $channel) {
                    if (isset($channelValues[$channelIndex]) && '1' === trim($channelValues[$channelIndex])) {
                        $data['requirements'][$channel][] = $code;
                    }
                }
            }
        }

        $data['attributes'] = implode(',', $data['attributes']);

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired(
            [
                'channel_label_row',
                'attribute_label_row',
                'attribute_data_row',
                'code_row',
                'code_column',
                'labels_column',
                'labels_label_row',
                'labels_data_row',
                'labels_column',
            ]
        );
    }
}
