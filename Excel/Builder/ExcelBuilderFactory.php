<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Builder;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Factory for Excel builders
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ExcelBuilderFactory
{
    /** @var ContainerInterface */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Creates an $builder for the given arguments
     *
     * @param string $class   The class of the $builder
     * @param array  $options The options of the $builder
     *
     * @return ExcelBuilderInterface
     */
    public function create($class, array $options = array())
    {
        $builder = new $class($options);

        if ($builder instanceof ContainerAwareInterface) {
            $builder->setContainer($this->container);
        }

        return $builder;
    }
}
