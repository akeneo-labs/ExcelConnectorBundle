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
        $this->initializeRecord();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        throw new \Exception('UNIMPLEMENTED');
    }

    /**
     * {@inheritdoc}
     */
    public function setFilePath($filePath)
    {
        parent::setFilePath($filePath);
        $reader = new \PHPExcel_Reader_Excel2007();
        $this->xls = $reader->load($filePath);
        $this->worksheetIterator = new \CallbackFilterIterator(
            $this->xls->getWorksheetIterator(),
            function ($worksheet) {
                return $this->isIncludedWorksheet($worksheet);
            }
        );
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

        if (isset($this->options['include_tabs'])) {
            $included = false;
            foreach($this->options['include_tabs'] as $regexp) {
                if (preg_match($regexp, $title)) {
                    $included = true;
                    break;
                }
            }
            
            if (!$included) {
                return false;
            }
        }

        foreach($this->options['exclude_tabs'] as $regexp) {
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
                'exclude_tabs'  => array()
            )
        );
        $resolver->setOptional(array('include_tabs'));
    }

    /**
     * Returns an array of values for a row
     * 
     * @param \PHPExcel_Worksheet_Row $row
     * @param int $startColumn
     * 
     * @return array
     */
    protected function getRowData(\PHPExcel_Worksheet_Row $row, $startColumn = 0)
    {
        $cellIterator = $row->getCellIterator($startColumn);
        $cellIterator->setIterateOnlyExistingCells(false);
        
        return array_map(
            function ($cell) {
                return $cell->getValue();
            },
            iterator_to_array($cellIterator)
        );
    }

    /**
     * @param \PHPExcel_Worksheet $worksheet
     * 
     * @return \Iterator
     */
    abstract protected function createValuesIterator(\PHPExcel_Worksheet $worksheet);
}
