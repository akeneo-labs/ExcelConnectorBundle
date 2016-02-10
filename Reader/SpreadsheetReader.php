<?php

namespace Pim\Bundle\ExcelConnectorBundle\Reader;

use Pim\Component\Catalog\Repository\AttributeRepositoryInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Pim\Bundle\CatalogBundle\Validator\Constraints\File as AssertFile;

/**
 * XLSX file reader
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2014 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class SpreadsheetReader extends FileIteratorReader
{
    /** @var AttributeRepositoryInterface */
    protected $attributeRepository;

    /** @var string */
    protected $identifierCode;

    /**
     * @Assert\NotBlank(groups={"Execution"})
     * @AssertFile(
     *     groups={"Execution"},
     *     allowedExtensions={"xlsx", "xlsm", "csv"},
     * )
     */
    protected $filePath;

    /**
     * @Assert\NotBlank
     * @Assert\Choice(choices={",", ";", "|"}, message="The value must be one of , or ; or |")
     */
    protected $delimiter = ';';

    /**
     * @Assert\NotBlank
     * @Assert\Choice(choices={"""", "'"}, message="The value must be one of "" or '")
     */
    protected $enclosure = '"';

    /**
     * @Assert\NotBlank
     */
    protected $escape = '\\';

    /**
     * @Assert\NotBlank
     */
    protected $encoding = 'UTF8';

    /**
     * @param AttributeRepositoryInterface $attributeRepository
     */
    public function setAttributeRepository(AttributeRepositoryInterface $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * Get uploaded file constraints
     *
     * @return array
     */
    public function getUploadedFileConstraints()
    {
        return array(
            new Assert\NotBlank(),
            new AssertFile(
                array(
                    'allowedExtensions' => array('csv', 'xlsx', 'xlsm')
                )
            )
        );
    }


    /**
     * Set delimiter
     *
     * @param string $delimiter
     *
     * @return SpreadsheetReader
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    /**
     * Get delimiter
     *
     * @return string $delimiter
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }

    /**
     * Set enclosure
     *
     * @param string $enclosure
     *
     * @return SpreadsheetReader
     */
    public function setEnclosure($enclosure)
    {
        $this->enclosure = $enclosure;

        return $this;
    }

    /**
     * Get enclosure
     *
     * @return string $enclosure
     */
    public function getEnclosure()
    {
        return $this->enclosure;
    }

    /**
     * Set escape
     *
     * @param string $escape
     *
     * @return SpreadsheetReader
     */
    public function setEscape($escape)
    {
        $this->escape = $escape;

        return $this;
    }

    /**
     * Get escape
     *
     * @return string $escape
     */
    public function getEscape()
    {
        return $this->escape;
    }

    /**
     * Returns the encoding
     *
     * @return string
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * Sets the encoding
     *
     * @param string $encoding
     *
     * @return SpreadsheetReader
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigurationFields()
    {
        return array(
            'filePath' => array(
                'options' => array(
                    'label' => 'pim_base_connector.import.filePath.label',
                    'help'  => 'pim_base_connector.import.filePath.help'
                )
            ),
            'uploadAllowed' => array(
                'type'    => 'switch',
                'options' => array(
                    'label' => 'pim_base_connector.import.uploadAllowed.label',
                    'help'  => 'pim_base_connector.import.uploadAllowed.help'
                )
            ),
            'delimiter' => array(
                'options' => array(
                    'label' => 'pim_base_connector.import.delimiter.label',
                    'help'  => 'pim_base_connector.import.delimiter.help'
                )
            ),
            'enclosure' => array(
                'options' => array(
                    'label' => 'pim_base_connector.import.enclosure.label',
                    'help'  => 'pim_base_connector.import.enclosure.help'
                )
            ),
            'escape' => array(
                'options' => array(
                    'label' => 'pim_base_connector.import.escape.label',
                    'help'  => 'pim_base_connector.import.escape.help'
                )
            ),
            'encoding' => array(
                'options' => array(
                    'label' => 'pim_excel_connector.import.encoding.label',
                    'help'  => 'pim_excel_connector.import.encoding.help'
                )
            ),
        );
    }

    /**
     * Returns the extension of the read file
     *
     * @return string
     */
    protected function getExtension()
    {
        return pathinfo($this->getFilePath(), PATHINFO_EXTENSION);
    }

    /**
     * {@inheritdoc}
     */
    protected function getIteratorOptions()
    {
        $options = parent::getIteratorOptions();
        if ('csv' === $this->getExtension()) {
            $options['parser_options'] = [
                'delimiter' => $this->delimiter,
                'escape'    => $this->escape,
                'enclosure' => $this->enclosure,
                'encoding'  => $this->encoding
            ];
        }

        return $options;
    }

    /**
     * {@inheritdoc}
     */
    protected function convertNumericIdentifierToString(array $item)
    {
        $item = parent::convertNumericIdentifierToString($item);

        if (isset($item[$this->getIdentifierCode()]) && is_int($item[$this->getIdentifierCode()])) {
            $item[$this->getIdentifierCode()] = (string) $item[$this->getIdentifierCode()];
        }

        return $item;
    }

    /**
     * @return string
     */
    protected function getIdentifierCode()
    {
        if (null === $this->identifierCode) {
            $this->identifierCode = $this->attributeRepository->getIdentifierCode();
        }

        return $this->identifierCode;
    }
}
