<?php

namespace Pim\Bundle\ExcelConnectorBundle\Writer;

use Pim\Bundle\BaseConnectorBundle\Writer\File\FileWriter;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Xlsx file writer
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class XlsWriter extends FileWriter implements InitializableInterface
{
    /**
     * @var \PHPExcel
     */
    protected $xls;

    /**
     * @Assert\NotBlank(groups={"Execution"})
     */
    protected $filePath = '/tmp/export_%datetime%.xlsx';

    /**
     * @var array
     */
    protected $indexes;

    /**
     * @var array
     */
    protected $options;

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
    }

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $this->xls = new \PHPExcel;
        $this->indexes = array();
    }

    /**
     * @inheritdoc
     */
    public function write(array $data)
    {
        foreach ($data as $item) {
            $this->writeItem($this->getWorksheet($item), $item);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $this->cleanup();
        $writer = new \PHPExcel_Writer_Excel2007($this->xls);
        $writer->save($this->filePath);
    }

    /**
     * Writes the item in a worksheet
     * 
     * @param \PHPExcel_Worksheet $worksheet
     * @param array $item
     */
    protected function writeItem(\PHPExcel_Worksheet $worksheet, array $item)
    {
        $this->writeValues($worksheet, $this->indexes[$worksheet->getTitle()], array_values($item));
    }

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
     * Returns the worksheet name for a set of data
     *
     * @param array $data
     * 
     * @return string
     */
    protected function getWorksheetName(array $data)
    {
        return $this->options['worksheet_name'];
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
