<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

/**
 * Row iterator factory
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class RowIteratorFactory
{
    /**
     * Constructor
     *
     * @param string $iteratorClass the class for row iterators
     */
    public function __construct($iteratorClass)
    {
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * Creates a row iterator for the XML given worksheet file
     *
     * @param SharedStrings $sharedStrings the content cache for the workbook
     * @param string       $path         the path to the extracted XML worksheet file
     *
     * @return RowIterator
     */
    public function create(SharedStrings $sharedStrings, $path)
    {
        throw new \Exception('NOT IMPLEMENTED');
    }
}
