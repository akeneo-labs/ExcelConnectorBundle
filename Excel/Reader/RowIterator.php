<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

/**
 * Row iterator for an Excel worksheet
 *
 * The iterator returns arrays of results.
 *
 * Empty values are trimmed from the right of the rows, and empty rows are skipped.
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class RowIterator implements \Iterator
{
    /**
     * {@inheritdoc}
     */
    public function __construct(ContentCache $contentCache, $path)
    {
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        throw new \Exception('NOT IMPLEMENTED');
    }
}
