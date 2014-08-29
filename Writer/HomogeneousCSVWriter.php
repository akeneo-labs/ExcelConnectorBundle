<?php

namespace Pim\Bundle\ExcelConnectorBundle\Writer;

use Pim\Bundle\BaseConnectorBundle\Writer\File\FileWriter;
use Pim\Bundle\BaseConnectorBundle\Writer\File\ArchivableWriterInterface;

/**
 * Writes normalized array in an homogeneous file
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2014 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class HomogeneousCSVWriter extends FileWriter implements ArchivableWriterInterface
{
    /**
     * @Assert\NotBlank
     * @Assert\Choice(choices={",", ";", "|"}, message="The value must be one of , or ; or |")
     * @var string
     */
    protected $delimiter = ';';

    /**
     * @Assert\NotBlank
     * @Assert\Choice(choices={"""", "'"}, message="The value must be one of "" or '")
     * @var string
     */
    protected $enclosure = '"';

    /**
     * @var boolean
     */
    protected $withHeader = true;

    /**
     * @var array
     */
    private $writtenFiles;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var resource
     */
    private $file;

    /**
     * Set the csv delimiter character
     *
     * @param string $delimiter
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
    }

    /**
     * Get the csv delimiter character
     *
     * @return string
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }

    /**
     * Set the csv enclosure character
     *
     * @param string $enclosure
     */
    public function setEnclosure($enclosure)
    {
        $this->enclosure = $enclosure;
    }

    /**
     * Get the csv enclosure character
     *
     * @return string
     */
    public function getEnclosure()
    {
        return $this->enclosure;
    }

    /**
     * Set whether or not to print a header row into the csv
     *
     * @param boolean $withHeader
     */
    public function setWithHeader($withHeader)
    {
        $this->withHeader = $withHeader;
    }

    /**
     * Get whether or not to print a header row into the csv
     *
     * @return boolean
     */
    public function isWithHeader()
    {
        return $this->withHeader;
    }

    /**
     * {@inheritdoc}
     */
    public function getWrittenFiles()
    {
        return $this->writtenFiles;
    }

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $this->writtenFiles = [];
        $this->file = fopen($this->get, 'w');
    }


    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $this->headers = null;
        $this->file = fopen($this->get, 'w');
    }
    /**
     * {@inheritdoc}
     */
    public function getConfigurationFields()
    {
        return
            array_merge(
                parent::getConfigurationFields(),
                array(
                    'delimiter' => array(
                        'options' => array(
                            'label' => 'pim_base_connector.export.delimiter.label',
                            'help'  => 'pim_base_connector.export.delimiter.help'
                        )
                    ),
                    'enclosure' => array(
                        'options' => array(
                            'label' => 'pim_base_connector.export.enclosure.label',
                            'help'  => 'pim_base_connector.export.enclosure.help'
                        )
                    ),
                    'withHeader' => array(
                        'type' => 'switch',
                        'options' => array(
                            'label' => 'pim_base_connector.export.withHeader.label',
                            'help'  => 'pim_base_connector.export.withHeader.help'
                        )
                    ),
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function write(array $items)
    {
        if (!count($items)) {
            return;
        }

        if (true === $this->withHeader && null === $this->headers) {
            $this->headers = array_keys(array_shift($items));
            $this->writeHeaders();
        }

        foreach ($items as $item) {
            $this->writeItem($row);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function writeItem(array $item)
    {
        $this->writeLine(
            array_map(
                function ($key) use ($item) {
                    return isset($item[$key]) ? $item[$key] : '';
                },
                $this->headers
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function writeHeaders()
    {
        $this->writeLine($this->headers);
    }

    /**
     * Writes a CSV in the line
     * 
     * @param array $csv
     */
    protected function writeLine(array $csv)
    {
        fputcsv($this->file, $row, $this->delimiter, $this->enclosure);
    }
}