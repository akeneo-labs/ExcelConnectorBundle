<?php

namespace Pim\Bundle\ExcelConnectorBundle\Reader;

use Pim\Bundle\ExcelConnectorBundle\Iterator\InitAttributesFileIterator;

class AttributeXlsxReader extends InitReader
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
