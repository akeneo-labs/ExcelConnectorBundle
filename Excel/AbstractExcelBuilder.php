<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
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
    /**
     * @var array
     */
    protected $indexes;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var \PHPExcel
     */
    protected $xls;

    /**
     * @var boolean
     */
    protected $clean = false;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $resolver = new OptionsResolver;
        $this->setDefaultOptions($resolver);
        $this->options = $resolver->resolve($options);
        $this->xls = new \PHPExcel;
    }

    /**
     * {@inheritdoc}
     */
    public function add(array $item)
    {
        $worksheet = $this->getWorksheet($item);
        $this->writeValues($worksheet, $this->indexes[$worksheet->getTitle()], array_values($item));
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
        if (!isset($this->indexes[$name])) {
            $worksheet = $this->createWorksheet($name, $data);
        }

        return $worksheet;
    }

    /**
     * Creates a worksheet with the given name
     *
     * @param type $name
     * @param array $data
     *
     * @return array \PHPExcelWorksheet
     */
    protected function createWorksheet($name, array $data)
    {
        $worksheet = $this->xls->createSheet();
        $worksheet->setTitle($name);
        $this->indexes[$name] = $this->options['data_row'];
        $this->writeLabels($worksheet, $data);
    }

    /**
     * Cleanup the Excel file
     */
    protected function cleanup() {
        $this->xls->removeSheetByIndex(0);
    }

    /**
     * Writes labels for the submitted data
     *
     * @param \PHPExcel_Worksheet $worksheet
     * @param array $data
     */
    protected function writeLabels(\PHPExcel_Worksheet $worksheet, array $data)
    {
        $this->writeValues($worksheet, $this->options['label_row'], array_keys($data));
    }

    /**
     * Writes a row of values
     *
     * @param \PHPExcel_Worksheet $worksheet
     * @param array $data An array of values with column indexes as keys
     */
    protected function writeValues(\PHPExcel_Worksheet $worksheet, $rowIndex, array $data)
    {
        foreach($data as $columnIndex => $value) {
            $worksheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
        }
    }

    /**
     * Sets the default options
     *
     * @param OptionsResolverInterface $resolver
     */
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'label_row' => 1,
                'data_row'  => 2
            )
        );
    }
}
