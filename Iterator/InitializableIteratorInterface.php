<?php

namespace Pim\Bundle\ExcelConnectorBundle\Iterator;

/**
 * Interface for iterators with an initialize method
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
interface InitializableIteratorInterface
{
    /**
     * Initializes the iterator
     */
    public function initialize();
}
