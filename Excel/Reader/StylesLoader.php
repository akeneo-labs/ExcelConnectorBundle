<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

/**
 * Styles factory
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class StylesLoader
{
    /**
     * @var string
     */
    protected $class;

    /**
     * Constructor
     *
     * @param string $class The class for created objects
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * Creates a Styles from the archive
     *
     * @param string $path
     *
     * @return Styles
     */
    public function open($path)
    {
        return new $this->class($path);
    }
}
