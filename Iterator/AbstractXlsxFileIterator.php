<?php

namespace Pim\Bundle\ExcelConnectorBundle\Iterator;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * XLSX File iterator
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
abstract class AbstractXlsxFileIterator extends AbstractFileIterator
{
    /**
     * @var XlsxFileIterator
     */
    protected $xls;

    /**
     * @var \Iterator
     */
    protected $worksheetIterator;

    /**
     * @var Iterator
     */
    protected $valuesIterator;

    /**
     * Constructor
     *
     * @param string $filePath
     * @param array  $options
     */
    public function __construct($filePath, array $options = array())
    {
        parent::__construct($filePath, $options);

        $reader = new \PHPExcel_Reader_Excel2007();
        $this->xls = $reader->load($filePath);
        $this->worksheetIterator = new \CallbackFilterIterator(
            $this->xls->getWorksheetIterator(),
            function ($worksheet) {
                return $this->isIncludedWorksheet($worksheet);
            }
        );
        $this->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->valuesIterator->current();
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return sprintf('%s/%s', $this->worksheetIterator->key(), $this->valuesIterator->key());
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->valuesIterator->next();
        if (!$this->valuesIterator->valid()) {
            $this->worksheetIterator->next();
            if ($this->worksheetIterator->valid()) {
                $this->initializeValuesIterator();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->worksheetIterator->rewind();
        if ($this->worksheetIterator->valid()) {
            $this->initializeValuesIterator();
        } else {
            $this->valuesIterator = null;
        }
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return $this->worksheetIterator->valid() && $this->valuesIterator && $this->valuesIterator->valid();
    }

    /**
     * Initializes the current record
     *
     * @return type
     */
    protected function initializeValuesIterator()
    {
        $this->valuesIterator = $this->createValuesIterator($this->worksheetIterator->current());
        if (!$this->valuesIterator->valid()) {
            $this->valuesIterator = null;
            $this->worksheetIterator->next();
            if ($this->worksheetIterator->valid()) {
                $this->initializeValuesIterator();
            }
        }
    }

    /**
     * Returns true if the worksheet should be included
     *
     * @param \PHPExcel_Worksheet $worksheet
     *
     * @return boolean
     */
    protected function isIncludedWorksheet(\PHPExcel_Worksheet $worksheet)
    {
        $title = $worksheet->getTitle();

        if (isset($this->options['include_worksheets'])) {
            $included = false;
            foreach ($this->options['include_worksheets'] as $regexp) {
                if (preg_match($regexp, $title)) {
                    $included = true;
                    break;
                }
            }

            if (!$included) {
                return false;
            }
        }

        foreach ($this->options['exclude_worksheets'] as $regexp) {
            if (preg_match($regexp, $title)) {
                return false;
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'exclude_worksheets'  => array()
            )
        );
        $resolver->setOptional(array('include_worksheets'));
    }

    /**
     * Returns an array of values for a row number
     *
     * @param \PHPExcel_Worksheet $worksheet
     * @param int                 $row
     * @param int                 $startColumn
     *
     * @return array
     */
    protected function getRowDataForRowNumber(\PHPExcel_Worksheet $worksheet, $row, $startColumn = 0)
    {
        return $this->getRowData($worksheet->getRowIterator($row)->current(), $startColumn);
    }

    /**
     * Returns an array of values for a row
     *
     * @param \PHPExcel_Worksheet_Row $row
     * @param int                     $startColumn
     *
     * @return array
     */
    protected function getRowData(\PHPExcel_Worksheet_Row $row, $startColumn = 0)
    {
        $cellIterator = $row->getCellIterator($startColumn);
        $cellIterator->setIterateOnlyExistingCells(false);

        $values = array_map(
            function ($cell) {
                return $cell->getValue();
            },
            iterator_to_array($cellIterator)
        );

        while (count($values) && !$values[count($values) - 1]) {
            unset($values[count($values) - 1]);
        }

        return $values;
    }

    /**
     * Resizes an array to the specified data count
     *
     * @param array $data
     * @param int   $count
     *
     * @return array
     */
    protected function resizeArray(array $data, $count)
    {
        if (count($data) < $count) {
            $data = array_merge($data, array_fill(0, $count - count($data), ''));
        }

        return array_slice($data, 0, $count);
    }

    /**
     * @param \PHPExcel_Worksheet $worksheet
     *
     * @return \Iterator
     */
    abstract protected function createValuesIterator(\PHPExcel_Worksheet $worksheet);
}
