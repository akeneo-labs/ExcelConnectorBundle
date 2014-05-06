<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

/**
 * Contains the shared strings of an Excel workbook
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class SharedStrings
{
    /**
     * @var \XMLReader
     */
    protected $xml;

    /**
     * @var boolean
     */
    protected $valid = true;

    /**
     * @var array
     */
    protected $values = [];

    /**
     * @var int
     */
    protected $currentIndex = -1;

    /**
     * Constructor
     *
     * @param string $path path to the extracted shared strings XML file
     */
    public function __construct($path)
    {
        $this->xml = new \XMLReader();
        $this->xml->open($path);
    }

    /**
     * Returns a shared string by index
     *
     * @param int $index
     *
     * @throws \InvalidArgumentException
     */
    public function get($index)
    {
        while ($this->valid && !isset($this->values[$index])) {
            $this->readNext();
        }
        if ((!isset($this->values[$index]))) {
            throw new \InvalidArgumentException(sprintf('No value with index %s', $index));
        }

        return $this->values[$index];
    }

    /**
     * Reads the next value in the file
     */
    protected function readNext()
    {
        while ($this->xml->read()) {
            if (\XMLReader::ELEMENT === $this->xml->nodeType) {
                switch ($this->xml->name) {
                    case 'si' :
                        $this->currentIndex++;
                        break;
                    case 't' :
                        $this->values[$this->currentIndex] = $this->xml->readString();

                        return;
                }
            }
        }

        $this->valid = false;
    }

    /**
     * Closes the XMLReader instance
     */
    public function __destruct()
    {
        if ($this->xml) {
            $this->xml->close();
        }
    }
}
