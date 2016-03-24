<?php

namespace Pim\Bundle\ExcelConnectorBundle\Reader;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Akeneo\Bundle\BatchBundle\Item\UploadedFileAwareInterface;
use Pim\Bundle\ExcelConnectorBundle\Iterator\FileIteratorFactory;
use Pim\Bundle\CatalogBundle\Validator\Constraints\File as AssertFile;

/**
 * File iterator reader
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class FileIteratorReader extends AbstractIteratorReader implements UploadedFileAwareInterface
{
    /** @var FileIteratorFactory */
    protected $iteratorFactory;

    /** @var string */
    protected $iteratorClass;

    /** @var array */
    protected $iteratorOptions;

    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"Execution"})
     * @AssertFile(groups={"Execution"})
     */
    protected $filePath;

    /**
     * @var boolean
     *
     * @Assert\Type(type="bool")
     * @Assert\True(groups={"UploadExecution"})
     */
    protected $uploadAllowed = false;

    /**
     * @param FileIteratorFactory $iteratorFactory
     * @param string              $iteratorClass
     * @param array               $iteratorOptions
     * @param bool                $batchMode
     */
    public function __construct(
        FileIteratorFactory $iteratorFactory,
        $iteratorClass,
        array $iteratorOptions = array(),
        $batchMode = false
    ) {
        parent::__construct($batchMode);

        $this->iteratorFactory = $iteratorFactory;
        $this->iteratorClass = $iteratorClass;
        $this->iteratorOptions = $iteratorOptions;
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
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getUploadedFileConstraints()
    {
        return array(
            new Assert\NotBlank(),
            new AssertFile()
        );
    }

    /**
     * @param File $uploadedFile
     *
     * @return FileIteratorReader
     */
    public function setUploadedFile(File $uploadedFile)
    {
        $this->filePath = $uploadedFile->getRealPath();
        $this->initialize();

        return $this;
    }

    /**
     * @param string $filePath
     *
     * @return FileIteratorReader
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
        $this->initialize();

        return $this;
    }

    /**
     * @param boolean $uploadAllowed
     *
     * @return FileIteratorReader
     */
    public function setUploadAllowed($uploadAllowed)
    {
        $this->uploadAllowed = $uploadAllowed;

        return $this;
    }

    /**
     * @return boolean $uploadAllowed
     */
    public function isUploadAllowed()
    {
        return $this->uploadAllowed;
    }

    /**
     * @return string $filePath
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * {@inheritdoc}
     */
    protected function createIterator()
    {
        return $this->iteratorFactory->create($this->iteratorClass, $this->filePath, $this->getIteratorOptions());
    }

    /**
     * @return array
     */
    protected function getIteratorOptions()
    {
        return $this->iteratorOptions;
    }

    /**
     * {@inheritdoc}
     */
    protected function convertNumericIdentifierToString(array $item)
    {
        if (isset($item['code']) && is_int($item['code'])) {
            $item['code'] = (string) $item['code'];
        }

        return $item;
    }
}
