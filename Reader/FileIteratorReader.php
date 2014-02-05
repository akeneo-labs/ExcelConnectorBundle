<?php

namespace Pim\Bundle\ExcelConnectorBundle\Reader;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Oro\Bundle\BatchBundle\Item\UploadedFileAwareInterface;
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
    /**
     * @var FileIteratorFactory
     */
    protected $iteratorFactory;

    /**
     * @var string
     */
    protected $iteratorClass;

    /**
     * @var array
     */
    protected $iteratorOptions;

    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"Execution"})
     * @AssertFile(groups={"Execution"})
     */
    protected $filePath;

    /**
     * @var string
     *
     * @Assert\Type(type="bool")
     * @Assert\True(groups={"UploadExecution"})
     */
    protected $uploadAllowed = false;

    /**
     * Constructor
     *
     * @param FileIteratorFactory $iteratorFactory
     * @param string              $iteratorClass
     * @param array               $iteratorOptions
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
     * Set uploaded file
     *
     * @param string $uploadedFile
     *
     * @return AbstractFileIteratorReader
     */
    public function setUploadedFile(File $uploadedFile)
    {
        $this->filePath = $uploadedFile->getRealPath();
        $this->reset();

        return $this;
    }

    /**
     * Set file path
     *
     * @param string $filePath
     *
     * @return AbstractFileIteratorReader
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
        $this->reset();

        return $this;
    }

    /**
     * Set the uploadAllowed property
     *
     * @param boolean $uploadAllowed
     *
     * @return AbstractFileIteratorReader
     */
    public function setUploadAllowed($uploadAllowed)
    {
        $this->uploadAllowed = $uploadAllowed;

        return $this;
    }

    /**
     * Get the uploadAllowed property
     *
     * @return boolean $uploadAllowed
     */
    public function isUploadAllowed()
    {
        return $this->uploadAllowed;
    }

    /**
     * Get file path
     *
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
        $iterator = $this->iteratorFactory->create($this->iteratorClass, $this->filePath, $this->iteratorOptions);

        if ($iterator instanceof InitializableIteratorInterface) {
            $iterator->initialize();
        }

        return $iterator;
    }
}
