<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Encoder;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Encoder\Excel2003XmlEncoder;

class Excel2003XmlEncoderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Encoder\Excel2003XmlEncoder');
    }

    function it_encodes_rows()
    {
        $this->encode(['2012', 18.5,'18.5', 'string'], Excel2003XmlEncoder::FORMAT_NAME)
            ->shouldReturn(
                '<Row><Cell><Data ss:Type="Number">2012</Data></Cell><Cell><Data ss:Type="Number">18.5</Data></Cell>' .
                '<Cell><Data ss:Type="Number">18.5</Data></Cell><Cell><Data ss:Type="String">string</Data></Cell></Row>'
            );
    }

    function it_supports_excel_2003_xml_format()
    {
        $this->supportsEncoding(Excel2003XmlEncoder::FORMAT_NAME)->shouldReturn(true);
    }
}
