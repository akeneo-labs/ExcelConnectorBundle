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
     * @var string
     */
    private $value;

    /**
     * Constructor
     *
     * @param \Iterator $innerIterator
     */
    public function __construct(\Iterator $innerIterator)
    {
        parent::__construct($innerIterator);
        $this->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function accept()
    {
        $iterator = $this->getInnerIterator();
        $this->value = $iterator->valid()
                ? $this->trimArray($iterator->current())
                : array();

        return $iterator->valid() && (count($this->value) > 0);
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->value;
    }

    /**
     * Strips empty values from the end of an array
     *
     * @param array $values
     *
     * @return array
     */
    protected function trimArray(array $values)
    {
        while (count($values) && '' === trim($values[count($values) - 1])) {
            unset($values[count($values) - 1]);
        }

        return $values;
    }
}
