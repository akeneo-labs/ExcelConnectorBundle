<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

/**
 * Relationships loader
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class RelationshipsLoader
{
    /**
     * Constructor
     *
     * @param string $relationshipClass The class of the relationship objects
     */
    public function __construct($relationshipClass)
    {
        throw new \Exception('NOT IMPLEMENTED');;
    }

    /**
     * Opens a relationships file
     *
     * @param string $path
     *
     * @return Relationships
     */
    public function open($path)
    {
        throw new \Exception('NOT IMPLEMENTED');;
    }
}
