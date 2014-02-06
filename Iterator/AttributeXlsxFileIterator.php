<?php

namespace Pim\Bundle\ExcelConnectorBundle\Iterator;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Attribute XLSX file iterator
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class AttributeXlsxFileIterator extends \FilterIterator implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var array
     */
    protected $attributeTypes;

    /**
     * @var XlsxFileIterator
     */
    private $innerIterator;

    /**
     * Constructor
     *
     * @param string $filePath
     * @param array  $options
     */
    public function __construct($filePath, array $options = array())
    {
        $this->innerIterator = new XlsxFileIterator($filePath, $options);
        parent::__construct($this->innerIterator);
    }

    /**
     * {@inheritdoc}
     */
    public function accept()
    {
        $data = $this->current();
        unset($data['code']);

        foreach ($data as $value) {
            if (trim($value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        $item = parent::current();
        unset($item['use_as_label']);

        if (isset($item['type'])) {
            if (isset($this->attributeTypes[$item['type']])) {
                $item['attribute_type'] = $this->attributeTypes[$item['type']];
            }
            unset($item['type']);
        }

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        parent::rewind();
        $this->initializeAttributeTypes();
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->innerIterator->setContainer($container);
    }

    /**
     * Returns the Excel Helper service
     *
     * @return \Pim\Bundle\ExcelConnectorBundle\Excel\ExcelHelper
     */
    protected function getExcelHelper()
    {
        return $this->container->get('pim_excel_connector.excel.helper');
    }

    /**
     * Initializes the attribute types dictionnary
     */
    protected function initializeAttributeTypes()
    {
        $attributeWorksheet = $this->getAttributeWorksheet();
        $helper = $this->getExcelHelper();
        $this->attributeTypes = array();
        foreach ($attributeWorksheet->getRowIterator(2) as $row) {
            $data = $helper->getRowData($row);
            $this->attributeTypes[$data[1]] = $data[0];
        }
    }

    /**
     * Returns the attribute worksheet
     *
     * @throws \RuntimeException
     *
     * @return \PHPExcel_Worksheet
     */
    protected function getAttributeWorksheet()
    {
        $xls = $this->innerIterator->getExcelObject();
        $attributeWorksheet = null;
        foreach ($xls->getWorksheetIterator() as $worksheet) {
            if ($worksheet->getTitle() == 'attribute_types') {
                $attributeWorksheet = $worksheet;
                break;
            }
        }
        if (!$attributeWorksheet) {
            throw new \RuntimeException('No attribute_types worksheet in the excel file');
        }

        return $attributeWorksheet;
    }
}
