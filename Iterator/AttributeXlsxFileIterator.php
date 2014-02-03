<?php

namespace Pim\Bundle\ExcelConnectorBundle\Iterator;

/**
 * Attribute XLSX file iterator
 * 
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class AttributeXlsxFileIterator extends \FilterIterator implements FileIteratorInterface
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(new XlsxFileIterator());
    }

    /**
     * {@inheritdoc}
     */
    public function accept()
    {
        $data = $this->current();
        unset($data['code']);
        
        foreach($data as $value) {
            if (trim($value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function setFilePath($filePath)
    {
        $this->getInnerIterator()->setFilePath($filePath);
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(array $options)
    {
        $this->getInnerIterator()->setOptions($options);
    }
}
