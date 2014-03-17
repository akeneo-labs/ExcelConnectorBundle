<?php

namespace Pim\Bundle\ExcelConnectorBundle\Writer;

use Akeneo\Bundle\BatchBundle\Entity\StepExecution;
use Pim\Bundle\BaseConnectorBundle\Writer\File\FileWriter;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Excel 97 XML writer
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Excel2003XmlWriter extends FileWriter
{
    /**
     * @staticvar string
     */
    const COLUMN_XML = '<Column ss:Span="1" ss:Width="64,008"/>';

    /**
     * @var EncoderInterface
     */
    protected $encoder;

    /**
     * @var string
     */
    protected $format;

    /**
     * @var string
     */
    protected $headerTemplate;

    /**
     * @var string
     */
    protected $footerTemplate;

    /**
     * @Assert\NotBlank(groups={"Execution"})
     */
    protected $filePath = '/tmp/export_%datetime%.xml';

    /**
     * @var array
     */
    protected $labels;

    /**
     * @var int
     */
    protected $tempHandler;

    /**
     * @var int
     */
    protected $handler;

    /**
     * Constructor
     *
     * @param EncoderInterface $encoder
     * @param string           $format
     * @param string           $headerTemplate
     * @param string           $footerTemplate
     */
    public function __construct(EncoderInterface $encoder, $format, $headerTemplate, $footerTemplate)
    {
        $this->encoder = $encoder;
        $this->format = $format;
        $this->headerTemplate = $headerTemplate;
        $this->footerTemplate = $footerTemplate;
    }

    /**
     * {@inheritdoc}
     */
    public function write(array $items)
    {
        foreach ($items as $item) {
            $this->writeItem($item);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $this->labels = array();
        $this->tempHandler = fopen('php://temp', 'rw');
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $this->handler = fopen($this->getPath(), 'w');
        $this->writeHeader();
        $this->writeColumns();
        $this->writeLabels();
        stream_copy_to_stream(fseek($this->tempHandler, 0), $this->handler);
        $this->writeFooter();
        fclose($this->tempHandler);
        fclose($this->handler);
    }

    /**
     * Writes an item
     *
     * @param array $item
     */
    protected function writeItem(array $item)
    {
        $context = $this->getContext($item);
        $row = array();
        foreach ($this->labels as $header) {
            if (array_key_exists($header, $item)) {
                $row[] = $item[$header];
                unset($item['header']);
            } else {
                $row[] = '';
            }
        }

        foreach ($item as $header => $value) {
            $this->labels[] = $header;
            $row[] = $value;
        }

        fwrite($this->tempHandler, $this->encoder->encode($value, $this->format, $context));

        if ($this->stepExecution) {
            $this->stepExecution->incrementSummaryInfo('write');
        }
    }

    /**
     * Returns the context for an encoder
     *
     * @param array $item
     *
     * @return array
     */
    protected function getContext(array $item)
    {
        return [];
    }

    /**
     * Writes the header of the XML file
     */
    protected function writeHeader()
    {
        $this->appendFile($this->headerTemplate);
    }

    /**
     * Writes the footer of the XML file
     */
    protected function writeFooter()
    {
        $this->appendFile($this->footerTemplate);
    }

    /**
     * Writes the Columns section of the XML file
     */
    protected function writeColumns()
    {
        fwrite($this->handler, implode('', array_fill(0, count($this->labels), static::COLUMN_XML)));
    }

    /**
     * Writes the labels row of the XML file
     */
    protected function writeLabels()
    {
        fwrite($this->handler, $this->encoder->encode($this->labels, $this->format));
    }

    /**
     * Appends the contents of a file to the XML file
     *
     * @param string $fileName
     */
    protected function appendFile($fileName)
    {
        $fd = fopen($fileName, 'r');
        stream_copy_to_stream($fd, $this->handler);
        fclose($fd);
    }
}
