<?php

namespace Pim\Bundle\ExcelConnectorBundle\Iterator;

use Akeneo\Component\SpreadsheetParser\SpreadsheetInterface;
use Akeneo\Component\SpreadsheetParser\SpreadsheetLoader;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * XLSX File iterator
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
abstract class AbstractXlsxFileIterator extends AbstractFileIterator implements ContainerAwareInterface
{
    /** @var ContainerInterface */
    protected $container;

    /** @var Iterator */
    protected $worksheetIterator;

    /** @var Iterator */
    protected $valuesIterator;

    /** @var SpreadsheetInterface */
    private $xls;

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
        return sprintf('%s/%s', $this->worksheetIterator->current(), $this->valuesIterator->key());
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
        $xls = $this->getExcelObject();
        $this->worksheetIterator = new \CallbackFilterIterator(
            new \ArrayIterator($xls->getWorksheets()),
            function ($title, $key) use ($xls) {
                return $this->isReadableWorksheet($title);

                return false;
            }
        );
        $this->worksheetIterator->rewind();
        if ($this->worksheetIterator->valid()) {
            $this->initializeValuesIterator();
        } else {
            $this->valuesIterator = null;
        }
    }

    /**
     * Returns the associated Excel object
     *
     * @return SpreadsheetInterface
     */
    public function getExcelObject()
    {
        if (!$this->xls) {
            $this->xls = $this->getWorkbookLoader()->open($this->filePath);
        }

        return $this->xls;
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return $this->worksheetIterator->valid() && $this->valuesIterator && $this->valuesIterator->valid();
    }

    /**
     * Initializes the current worksheet
     */
    protected function initializeValuesIterator()
    {
        $this->valuesIterator = $this->createValuesIterator();

        if (!$this->valuesIterator->valid()) {
            $this->valuesIterator = null;
            $this->worksheetIterator->next();
            if ($this->worksheetIterator->valid()) {
                $this->initializeValuesIterator();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Returns true if the worksheet should be read
     *
     * @param string $title
     *
     * @return boolean
     */
    protected function isReadableWorksheet($title)
    {
        return $this->isIncludedWorksheet($title) && !$this->isExcludedWorksheet($title);
    }

    /**
     * Returns true if the worksheet should be indluded
     *
     * @param string $title The title of the worksheet
     *
     * @return boolean
     */
    protected function isIncludedWorksheet($title)
    {
        if (!isset($this->options['include_worksheets'])) {
            return true;
        }

        foreach ($this->options['include_worksheets'] as $regexp) {
            if (preg_match($regexp, $title)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns true if the worksheet should be excluded
     *
     * @param string $title The title of the worksheet
     *
     * @return boolean
     */
    protected function isExcludedWorksheet($title)
    {
        foreach ($this->options['exclude_worksheets'] as $regexp) {
            if (preg_match($regexp, $title)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'exclude_worksheets' => array(),
                'parser_options'     => array()
            )
        );
        $resolver->setDefined(array('include_worksheets'));
    }

    /**
     * Returns the Array Helper service
     *
     * @return ArrayHelper
     */
    protected function getArrayHelper()
    {
        return $this->container->get('pim_excel_connector.iterator.array_helper');
    }

    /**
     * Returns the workbook reader
     *
     * @return SpreadsheetLoader
     */
    protected function getWorkbookLoader()
    {
        return $this->container->get('akeneo_spreadsheet_parser.spreadsheet_loader');
    }

    /**
     * Returns an iterator for the specified worksheet
     *
     * @param int $worksheetIndex
     *
     * @return \Iterator
     */
    protected function createIterator($worksheetIndex)
    {
       return $this->getExcelObject()->createRowIterator($worksheetIndex, $this->options['parser_options']);
    }

    /**
     * Creates the value iterator
     *
     * @return Iterator
     */
    abstract protected function createValuesIterator();
}
