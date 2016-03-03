<?php

namespace Pim\Bundle\ExcelConnectorBundle\Encoder;

use Symfony\Component\Serializer\Encoder\EncoderInterface;

/**
 * Excel 2003 Xml Encoder
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Excel2003XmlEncoder implements EncoderInterface
{
    /** @const string The name of the format */
    const FORMAT_NAME = 'excel_2003_xml';

    /** @const string XML template for one cell */
    const CELL_TEMPLATE='<Cell><Data ss:Type="{{type}}">{{data}}</Data></Cell>';

    /** @const string XML template for one row */
    const ROW_TEMPLATE='<Row>{{cells}}</Row>';

    /**
     * {@inheritdoc}
     */
    public function encode($data, $format, array $context = array())
    {
        $cells = '';
        foreach ($data as $value) {
            $cells .= strtr(
                static::CELL_TEMPLATE,
                [
                    '{{type}}' => is_numeric($value) ? 'Number' : 'String',
                    '{{data}}' => $value
                ]
            );
        }

        return strtr(static::ROW_TEMPLATE, [ '{{cells}}' => $cells ]);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsEncoding($format)
    {
        return static::FORMAT_NAME === $format;
    }
}
