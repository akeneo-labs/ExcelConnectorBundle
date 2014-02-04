<?php

namespace Pim\Bundle\ExcelConnectorBundle\Iterator;

/**
 * Factory for file iterators
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class FileIteratorFactory
{
    /**
     * Creates an iterator for the given arguments
     *
     * @param string $class    The class of the iterator
     * @param string $filePath The file which should be read
     * @param array  $options  The options of the iterator
     *
     * @return \Iterator
     */
    public function create($class, $filePath, array $options = array())
    {
        $iterator = new $class($filePath, $options);

        return $iterator;
    }
}
