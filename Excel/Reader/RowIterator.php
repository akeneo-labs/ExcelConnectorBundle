<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

/**
 * Row iterator for an Excel worksheet
 *
 * The iterator returns arrays of results.
 *
 * Empty values are trimed from the right of the rows, and empty rows are skipped.
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class RowIterator implements \Iterator
{
    /**
     * @var RowBuilderFactory
     */
    protected $rowBuilderFactory;

    /**
     * @var ColumnIndexTransformer
     */
    protected $columnIndexTransformer;

    /**
     * @var ValueTransformer
     */
    protected $valueTransformer;

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
     * @param ValueTransformer $valueTransformer
     * @param string           $path
     */
    public function __construct(
        RowBuilderFactory $rowBuilderFactory,
        ColumnIndexTransformer $columnIndexTransformer,
        ValueTransformer $valueTransformer,
        $path
    ) {
        $this->rowBuilderFactory = $rowBuilderFactory;
        $this->columnIndexTransformer = $columnIndexTransformer;
        $this->valueTransformer = $valueTransformer;
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
        $this->valid = false;

        while ($this->xml->read()) {
            if (\XMLReader::ELEMENT === $this->xml->nodeType) {
                switch ($this->xml->name) {
                    case 'row' :
                        $currentKey = (int) $this->xml->getAttribute('r');
                        $rowBuilder = $this->rowBuilderFactory->create();
                        break;
                    case 'c' :
                        $columnIndex = $this->columnIndexTransformer->transform($this->xml->getAttribute('r'));
                        $style = $this->getValue($this->xml->getAttribute('s'));
                        $type = $this->getValue($this->xml->getAttribute('t'));
                        break;
                    case 'v' :
                        $rowBuilder->addValue(
                            $columnIndex,
                            $this->valueTransformer->transform($this->xml->readString(), $type, $style)
                        );
                        break;
                }
            } elseif (\XMLReader::END_ELEMENT === $this->xml->nodeType) {
                switch ($this->xml->name) {
                    case 'row' :
                        $currentValue = $rowBuilder->getData();
                        if (count($currentValue)) {
                            $this->currentKey = $currentKey;
                            $this->currentValue = $currentValue;
                            $this->valid = true;

                            return;
                        }
                        break;
                    case 'sheetData' :
                        break 2;
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        if ($this->xml) {
            $this->xml->close();
        }
        $this->xml = new \XMLReader();
        $this->xml->open($this->path);
        $this->next();
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->valid;
    }

    /**
     * Returns a normalized attribute value
     *
     * @param string $value
     *
     * @return string
     */
    protected function getValue($value)
    {
       return null === $value ? ''  : $value;
    }
}
