<?php

namespace Pim\Bundle\ExcelConnectorBundle\Reader;

use Akeneo\Bundle\BatchBundle\Entity\StepExecution;
use Akeneo\Bundle\BatchBundle\Item\AbstractConfigurableStepElement;
use Akeneo\Bundle\BatchBundle\Item\ItemReaderInterface;
use Akeneo\Bundle\BatchBundle\Step\StepExecutionAwareInterface;

/**
 * Abstract iterator based reader
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
abstract class AbstractIteratorReader extends AbstractConfigurableStepElement implements ItemReaderInterface,
    StepExecutionAwareInterface
{
    /**
     * @var \Iterator
     */
    protected $iterator;

    /**
     * @var StepExecution
     */
    protected $stepExecution;

    /**
     * @var boolean
     */
    protected $batchMode;

    /**
     * Constructor
     *
     * @param boolean $batchMode
     */
    public function __construct($batchMode = false)
    {
        $this->batchMode = $batchMode;
    }

    public function setStepExecution(StepExecution $stepExecution)
    {
        $this->stepExecution = $stepExecution;
    }

    public function read()
    {
        if (!isset($this->iterator)) {
            $this->initializeIterator();
        }

        if (!$this->iterator->valid()) {
            return null;
        }

        $current = $this->iterator->current();
        if ($this->stepExecution) {
            $this->stepExecution->incrementSummaryInfo('read');
        }
        $this->iterator->next();

        return $this->convertNumericIdentifierToString($current);
    }

    /**
     * Resets the state of the reader
     */
    public function reset()
    {
        $this->iterator = null;
    }

    /**
     * Rewinds the iterator if it has already been initialized.
     * It allows to use the same service in two successive steps
     *
     * {@inheritdoc}
     */
    public function initialize()
    {
        $this->iterator = null;
    }

    /**
     * Converts an entity numerical identifier ('sku' for products,
     * 'code' for other entities) into string to allow import.
     *
     * @param array $item
     *
     * @return array
     */
    protected function convertNumericIdentifierToString(array $item)
    {
        return $item;
    }

    /**
     * Initializes the iterator
     */
    protected function initializeIterator()
    {
        $this->iterator = $this->createIterator();
        if ($this->batchMode) {
            $this->iterator = new \ArrayIterator(array(iterator_to_array($this->iterator)));
        }
        $this->iterator->rewind();
    }

    /**
     * Creates the iterator
     *
     * @return \Iterator
     */
    abstract protected function createIterator();
}
