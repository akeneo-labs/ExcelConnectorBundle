<?php

namespace Pim\Bundle\ExcelConnectorBundle\Writer;

use Pim\Bundle\BaseConnectorBundle\Writer\File\FileWriter;
use Symfony\Component\Validator\Constraints as Assert;
use Pim\Bundle\ExcelConnectorBundle\Excel\Builder\ExcelBuilderInterface;
use Pim\Bundle\ExcelConnectorBundle\Excel\Builder\ExcelBuilderFactory;

/**
 * Xlsx file writer
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class XlsxWriter extends FileWriter
{
    /**
     * @var string
     * @Assert\NotBlank(groups={"Execution"})
     */
    protected $filePath = '/tmp/export_%datetime%.xlsx';

    /** @var ExcelBuilderFactory */
    protected $builderFactory;

    /** @var string */
    protected $builderClass;

    /** @var array */
    protected $builderOptions;

    /** @var ExcelBuilderInterface */
    protected $builder;

    /**
     * @param ExcelBuilderFactory $builderFactory
     * @param string              $builderClass
     * @param array               $builderOptions
     */
    public function __construct(ExcelBuilderFactory $builderFactory, $builderClass, array $builderOptions = array())
    {
        $this->builderFactory = $builderFactory;
        $this->builderClass = $builderClass;
        $this->builderOptions = $builderOptions;
    }

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $this->builder = $this->builderFactory->create($this->builderClass, $this->builderOptions);
    }

    /**
     * @inheritdoc
     */
    public function write(array $data)
    {
        foreach ($data as $item) {
            $this->builder->add($item);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $writer = new \PHPExcel_Writer_Excel2007($this->builder->getExcelObject());
        $writer->save($this->getPath());
    }
}
