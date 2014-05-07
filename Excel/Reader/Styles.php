<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

/**
 * Workbook styles
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Styles extends AbstractXMLDictionnary
{
    /**
     * {@inheritdoc}
     */
    protected function readNext()
    {
        $xml = $this->getXMLReader();
        while ($xml->read()) {
            if (\XMLReader::END_ELEMENT === $xml->nodeType && 'numFmts' === $xml->name) {
                break;
            } elseif (\XMLReader::ELEMENT === $xml->nodeType && 'numFmt' === $xml->name) {
                $this->values[(string) $xml->getAttribute('numFmtId')] = (string) $xml->getAttribute('formatCode');

                return;
            }
        }

        $this->valid = false;
        $this->closeXMLReader();
    }
}
