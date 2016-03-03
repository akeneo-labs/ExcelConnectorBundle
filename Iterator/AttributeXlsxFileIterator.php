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
    /** @var array */
    protected $attributeTypes;

    /** @var array */
    protected $options;

    /** @var XlsxFileIterator */
    private $innerIterator;

    /**
     * @param string $filePath
     * @param array  $options
     */
    public function __construct($filePath, array $options = array())
    {
        $options['skip_empty'] = true;
        $this->innerIterator = new XlsxFileIterator($filePath, $options);
        $this->options = $options;

        parent::__construct($this->innerIterator);
    }

    /**
     * {@inheritdoc}
     */
    public function accept()
    {
        $data = $this->current();
        unset($data['code'], $data['use_as_label']);

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
                $item['type'] = $this->attributeTypes[$item['type']];
            }
        }

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->initializeAttributeTypes();
        parent::rewind();
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
     * @throws \RuntimeException
     */
    protected function initializeAttributeTypes()
    {
        $xls = $this->getInnerIterator()->getExcelObject();
        $parserOptions = isset($this->options['parser_options']) ? $this->options['parser_options'] : [] ;
        $this->attributeTypes = array();
        $attributeWorkseet = $xls->getWorksheetIndex('attribute_types');
        if (false === $attributeWorkseet) {
            throw new \RuntimeException('No attribute_types worksheet in the excel file');
        }
        $iterator = $xls->createRowIterator($attributeWorkseet, $parserOptions);

        foreach ($iterator as $key => $row) {
            if ($key >= 2) {
                $this->attributeTypes[$row[1]] = $row[0];
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function __clone()
    {
        return clone $this;
    }
}
