<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

/**
 * Transforms cell values according to their type
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ValueTransformer
{
    /**
     * @staticvar string Boolean type
     */
    const TYPE_BOOL = 'b';

    /**
     * @staticvar string Number type
     */
    const TYPE_NUMBER = 'n';

    /**
     * @staticvar string Error type
     */
    const TYPE_ERROR = 'e';

    /**
     * @staticvar string Shared string type
     */
    const TYPE_SHARED_STRING = 's';

    /**
     * @staticvar string String type
     */
    const TYPE_STRING = 'str';

    /**
     * @staticvar string Inline string type
     */
    const TYPE_INLINE_STRING = 'inlineStr';

    /**
     * Constructor
     *
     * @param DateTransformer $dateTransformer
     * @param SharedStrings   $sharedStrings
     */
    public function __construct(DateTransformer $dateTransformer, SharedStrings $sharedStrings, Styles $styles)
    {
        throw new \Exception('NOT IMPLEMENTED');
    }

    /**
     * Formats a value
     *
     * Only shared strings are transformed for this implementation
     *
     * @param string $value The value which should be transformed
     * @param string $type  The type of the value
     * @param string $style The style of the value
     *
     * @return mixed
     */
    public function transform($value, $type, $style)
    {
        throw new \Exception('NOT IMPLEMENTED');
    }
}
