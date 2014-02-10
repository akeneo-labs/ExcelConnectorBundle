<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel;

/**
 * Iterates through Excel rows, stopping at an e;pty row
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class RowIterator extends \IteratorIterator
{
    /**
     * @var ExcelHelper
     */
    protected $helper;

    /**
     * Constructor
     *
     * @param \Pim\Bundle\ExcelConnectorBundle\Excel\ExcelHelper $helper
     * @param \PHPExcel_Worksheet_RowIterator                    $innerIterator
     */
    public function __construct(ExcelHelper $helper, \PHPExcel_Worksheet_RowIterator $innerIterator)
    {
        $this->helper = $helper;
        parent::__construct($innerIterator);
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return (count($this->helper->getRowData(parent::current())) > 0) && parent::valid();
    }
}
