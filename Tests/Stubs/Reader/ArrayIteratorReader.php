<?php

namespace Pim\Bundle\ExcelConnectorBundle\Tests\Stubs\Reader;

use Pim\Bundle\ExcelConnectorBundle\Reader\AbstractIteratorReader;

/**
 * Stub used for testing AbstractIteratorReader
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ArrayIteratorReader extends AbstractIteratorReader
{
    /**
     * @var array
     */
    protected $values;

    public function __construct(array $values, $batchMode = false)
    {
        $this->values = $values;
        parent::__construct($batchMode);
    }

    protected function createIterator()
    {
        return new \ArrayIterator($this->values);
    }

    public function getConfigurationFields()
    {
        return array();
    }
}
