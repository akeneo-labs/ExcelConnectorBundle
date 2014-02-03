<?php

namespace Pim\Bundle\ExcelConnectorBundle\Iterator;

/**
 * Interface for file iterators
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
interface FileIteratorInterface extends \Iterator
{
    /**
     * Sets the options of the iterator
     *
     * @param array $options
     */
    public function setOptions(array $options);

    /**
     * Sets the path of the iterated file
     *
     * @param string $filePath
     */
    public function setFilePath($filePath);
}
