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
     * @var ContentCache
     */
    protected $contentCache;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var \XMLReader
     */
    protected $xml;

    /**
     * @var array
     */
    protected $currentKey;

    /**
     * @var array
     */
    protected $currentValue;

    /**
     * @var Boolean
     */
    protected $valid;

    /**
     * Constructor
     *
     * @param ContentCache $contentCache
     * @param string       $path
     */
    public function __construct(ContentCache $contentCache, $path)
    {
        $this->contentCache = $contentCache;
        $this->path = $path;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->currentValue;
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->currentKey;
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        // Should set $this->currentKey, $this->currentValue and $this->valid
        // According to the next found row tag in the xls file
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        if ($this->xml) {
            $this->xml->close();
        }
        $this->xml = new \XMLReader($this->path);
        $this->next();
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        throw new \Exception('NOT IMPLEMENTED');
    }
}
