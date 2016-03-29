<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Builder;

use PHPExcel;
use PHPExcel_Worksheet;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Base excel builder
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
abstract class AbstractExcelBuilder implements ExcelBuilderInterface
{
    /** @var array */
    protected $rowIndexes;

    /** @var array */
    protected $labels;

    /** @var array */
    protected $options;

    /** @var PHPExcel */
    protected $xls;

    /** @var boolean */
    protected $clean = false;

    /**
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $resolver = new OptionsResolver();
        $this->setDefaultOptions($resolver);
        $this->options = $resolver->resolve($options);
        $this->xls = new PHPExcel();
    }

    /**
     * {@inheritdoc}
     */
    public function add(array $item)
    {
        $worksheet = $this->getWorksheet($item);
        $this->writeLabels($worksheet, $item);
        $this->writeValues($worksheet, $item);
    }

    /**
     * {@inheritdoc}
     */
    public function getExcelObject()
    {
        if (!$this->clean) {
            $this->cleanup();
        }

        return $this->xls;
    }

    /**
     * Returns the worksheet name for a set of data
     *
     * @param array $data
     *
     * @return string
     */
    abstract protected function getWorksheetName(array $data);

    /**
     * Returns the worksheet for a set of data
     *
     * @param array $data
     *
     * @return \PHPExcel_Worksheet
     */
    protected function getWorksheet(array $data)
    {
        $name = $this->getWorksheetName($data);
        if (!isset($this->labels[$name])) {
            return $this->createWorksheet($name, $data);
        } else {
            return $this->xls->getSheetByName($name);
        }
    }

    /**
     * Creates a worksheet with the given name
     *
     * @param string $name
     * @param array  $data
     *
     * @return PHPExcel_Worksheet
     */
    protected function createWorksheet($name, array $data)
    {
        $worksheet = $this->xls->createSheet();
        $worksheet->setTitle($name);
        $this->rowIndexes[$name] = $this->options['data_row'];
        $this->labels[$name] = [];

        return $worksheet;
    }

    /**
     * Cleanup the Excel file
     */
    protected function cleanup()
    {
        if (count($this->labels)) {
            $this->xls->removeSheetByIndex(0);
        }
    }

    /**
     * Writes labels for the submitted data
     *
     * @param PHPExcel_Worksheet $worksheet
     * @param array               $data
     */
    protected function writeLabels(PHPExcel_Worksheet $worksheet, array $data)
    {
        $worksheetName = $worksheet->getTitle();
        $missing = array_diff(array_keys($data), $this->labels[$worksheetName]);
        $column = count($this->labels[$worksheetName]);
        foreach ($missing as $label) {
            $this->labels[$worksheetName][] = $label;
            $worksheet->setCellValueByColumnAndRow($column, $this->options['label_row'], $label);
            $column++;
        }
    }

    /**
     * Writes a row of values
     *
     * @param PHPExcel_Worksheet $worksheet
     * @param array               $data      An array of values with column indexes as keys
     */
    protected function writeValues(PHPExcel_Worksheet $worksheet, array $data)
    {
        $worksheetName = $worksheet->getTitle();
        $row = $this->rowIndexes[$worksheetName];
        foreach ($this->labels[$worksheet->getTitle()] as $column => $label) {
            if (isset($data[$label])) {
                $worksheet->setCellValueByColumnAndRow($column, $row, $data[$label]);
            }
        }

        $this->rowIndexes[$worksheetName]++;
    }

    /**
     * Sets the default options
     *
     * @param OptionsResolver $resolver
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'label_row' => 1,
                'data_row'  => 2
            )
        );
    }
}
