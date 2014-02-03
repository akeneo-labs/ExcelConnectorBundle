<?php

namespace Pim\Bundle\ExcelConnectorBundle\Reader;

use Oro\Bundle\BatchBundle\Entity\StepExecution;
use Oro\Bundle\BatchBundle\Item\AbstractConfigurableStepElement;
use Oro\Bundle\BatchBundle\Item\ItemReaderInterface;
use Oro\Bundle\BatchBundle\Step\StepExecutionAwareInterface;

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

    public function setStepExecution(StepExecution $stepExecution)
    {
        $this->stepExecution = $stepExecution;
    }

    public function read()
    {
        if (!isset($this->iterator)) {
            $this->iterator = $this->createIterator();
        }

        if (!$this->iterator->valid()) {
            return null;
        }

        $current = $this->iterator->current();
        if ($this->stepExecution) {
            $this->stepExecution->incrementSummaryInfo('read');
        }
        $this->iterator->next();

        return $current;
    }

    /**
     * Resets the state of the reader
     */
    public function reset()
    {
        $this->iterator = null;
    }

    /**
     * Creates the iterator
     *
     * @return \Iterator
     */
    abstract protected function createIterator();
}
