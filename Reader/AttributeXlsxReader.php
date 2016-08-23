<?php

namespace Pim\Bundle\ExcelConnectorBundle\Reader;

use Pim\Bundle\ExcelConnectorBundle\Iterator\InitAttributesFileIterator;
use Pim\Component\Connector\Reader\File\Xlsx\Reader;

class AttributeXlsxReader extends Reader
{
    /** @var InitAttributesFileIterator */
    protected $fileIterator;

    protected function getArrayConverterOptions()
    {
        return [
            'attribute_types_mapper' => $this->fileIterator->getAttributeTypesMapper()
        ];
    }
}
