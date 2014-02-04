<?php

namespace Pim\Bundle\ExcelConnectorBundle\Iterator;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Factory for file iterators
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class FileIteratorFactory
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Creates an iterator for the given arguments
     *
     * @param string $class    The class of the iterator
     * @param string $filePath The file which should be read
     * @param array  $options  The options of the iterator
     *
     * @return \Iterator
     */
    public function create($class, $filePath, array $options = array())
    {
        $iterator = new $class($filePath, $options);

        if ($iterator instanceof ContainerAwareInterface) {
            $iterator->setContainer($this->container);
        }

        if ($iterator instanceof InitializableIteratorInterface) {
            $iterator->initialize();
        }

        return $iterator;
    }
}
