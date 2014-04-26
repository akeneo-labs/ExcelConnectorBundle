<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel;

/**
 * Iterates through Excel rows, stopping at an empty row
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class RowIterator extends \FilterIterator
{
    /**
     * @var ExcelHelper
     */
    protected $helper;

    /**
     * Constructor
     *
     * @param ExcelHelper $helper
     * @param \Iterator   $innerIterator
     */
    public function __construct(ExcelHelper $helper, \Iterator $innerIterator)
    {
        $this->helper = $helper;
        parent::__construct($innerIterator);
        $this->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function accept()
    {
        $iterator = $this->getInnerIterator();

        return $iterator->valid() && (count($this->helper->getRowData($iterator->current())) > 0);
    }
}
