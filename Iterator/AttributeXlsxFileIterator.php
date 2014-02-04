<?php

namespace Pim\Bundle\ExcelConnectorBundle\Iterator;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Attribute XLSX file iterator
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class AttributeXlsxFileIterator extends \FilterIterator implements InitializableIteratorInterface, ContainerAwareInterface
{
    /**
     * @var array
     */
    protected $attributeTypes;

    /**
     * Constructor
     *
     * @param string $filePath
     * @param array  $options
     */
    public function __construct($filePath, array $options = array())
    {
        parent::__construct(new XlsxFileIterator($filePath, $options));
    }

    /**
     * {@inheritdoc}
     */
    public function accept()
    {
        $data = $this->current();
        unset($data['code']);

        foreach ($data as $value) {
            if (trim($value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        $item = parent::current();
        unset($item['use_as_label']);

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $this->getInnerIterator()->initialize();
        $this->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->getInnerIterator()->setContainer($container);
    }
}
