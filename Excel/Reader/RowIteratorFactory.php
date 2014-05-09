<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

/**
 * Row iterator factory
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class RowIteratorFactory
{

    /**
     *
     * @var RowBuilderFactory
     */
    protected $rowBuilderFactory;

    /**
     *
     * @var ColumnIndexTransformer
     */
    protected $columnIndexTransformer;

    /**
     *
     * @var string
     */
    protected $iteratorClass;

    /**
     * Constructor
     *
     * @param RowBuilderFactory      $rowBuilderFactory
     * @param ColumnIndexTransformer $columnIndexTransformer
     * @param string                 $iteratorClass          the class for row iterators
     */
    public function __construct(
        RowBuilderFactory $rowBuilderFactory,
        ColumnIndexTransformer $columnIndexTransformer,
        $iteratorClass
    )
    {
        $this->rowBuilderFactory = $rowBuilderFactory;
        $this->columnIndexTransformer = $columnIndexTransformer;
        $this->iteratorClass = $iteratorClass;
    }

    /**
     * Creates a row iterator for the XML given worksheet file
     *
     * @param ValueTransformer $valueTransformer the value transformer for the workbook
     * @param string           $path             the path to the extracted XML worksheet file
     *
     * @return RowIterator
     */
    public function create(ValueTransformer $valueTransformer, $path)
    {
        return new $this->iteratorClass($this->rowBuilderFactory, $this->columnIndexTransformer, $valueTransformer, $path);
    }

}
