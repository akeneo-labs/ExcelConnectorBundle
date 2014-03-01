<?php

namespace Pim\Bundle\ExcelConnectorBundle\Step;

use Akeneo\Bundle\BatchBundle\Entity\StepExecution;
use Akeneo\Bundle\BatchBundle\Step\ItemStep;
use Pim\Bundle\ExcelConnectorBundle\Writer\InitializableInterface;

/**
 * ItemStep for initializable writers
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class InitializableWriterItemStep extends ItemStep
{
    /**
     * {@inheritdoc}
     */
    public function doExecute(StepExecution $stepExecution)
    {
        if (!($this->writer instanceof InitializableInterface)) {
            throw new \Exception(
                    'Writer should be an instance of Pim\Bundle\ExcelConnectorBundle\Writer\InitializableInterface'
            );
        }

        $this->writer->initialize();
        parent::doExecute($stepExecution);
        $this->writer->flush();
    }
}
