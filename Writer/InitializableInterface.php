<?php

namespace Pim\Bundle\ExcelConnectorBundle\Writer;

/**
 * Interface for initializable writers
 * 
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
interface InitializableInterface
{
    /**
     * Initializes the writer
     */
    public function initialize();

    /**
     * Flushes the writer
     */
    public function flush();
}
