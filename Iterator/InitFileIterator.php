<?php

namespace Pim\Bundle\ExcelConnectorBundle\Iterator;

use Box\Spout\Reader\XLSX\Sheet;
use Box\Spout\Reader\XLSX\SheetIterator;
use Pim\Component\Connector\Reader\File\FileIterator;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * XSLX initialization file iterator
 *
 * @author    JM Leroux <jean-marie.leroux@akeneo.com>
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class InitFileIterator extends FileIterator
{
    /** @var SheetIterator */
    protected $worksheetIterator;

    /** @var array */
    protected $options;

    /**
     * {@inheritdoc}
     */
    public function __construct($type, $filePath, array $options = [])
    {
        parent::__construct($type, $filePath, $options);

        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        $data = $this->rows->current();

        if (!$this->valid() || null === $data || empty($data)) {
            $this->rewind();

            return null;
        }

        $data = $this->trimRight($data);

        return $data;
    }

    protected function trimRight($data)
    {
        $lastElement = end($data);
        while (false !== $lastElement && empty($lastElement)) {
            array_pop($data);
            $lastElement = end($data);
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        $worksheetName = $this->worksheetIterator->current()->getName();
        return sprintf('%s/%s', $worksheetName, $this->rows->key());
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return $this->worksheetIterator->valid() && $this->rows && $this->rows->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->rows->next();
        if (!$this->rows->valid()) {
            $this->worksheetIterator->next();
            if ($this->worksheetIterator->valid()) {
                $this->initializeValuesIterator();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->worksheetIterator = new \CallbackFilterIterator(
            $this->reader->getSheetIterator(),
            function (Sheet $currentSheet) {
                return $this->isReadableWorksheet($currentSheet->getName());
            }
        );
        $this->worksheetIterator->rewind();
        if ($this->worksheetIterator->valid()) {
            $this->initializeValuesIterator();
        }
    }

    /**
     * Initializes the current worksheet
     */
    protected function initializeValuesIterator()
    {
        $this->createValuesIterator();

        if (!$this->rows->valid() || !$this->isReadableWorksheet($this->reader->getSheetIterator()->current()->getName())) {
            $this->worksheetIterator->next();
            if ($this->worksheetIterator->valid()) {
                $this->initializeValuesIterator();
            }
        }
    }

    /**
     * Returns true if the worksheet should be read
     *
     * @param string $title
     *
     * @return boolean
     */
    protected function isReadableWorksheet($title)
    {
        return $this->isIncludedWorksheet($title) && !$this->isExcludedWorksheet($title);
    }

    /**
     * Returns true if the worksheet should be indluded
     *
     * @param string $title The title of the worksheet
     *
     * @return boolean
     */
    protected function isIncludedWorksheet($title)
    {
        if (!isset($this->options['include_worksheets'])) {
            return true;
        }

        foreach ($this->options['include_worksheets'] as $regexp) {
            if (preg_match($regexp, $title)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns true if the worksheet should be excluded
     *
     * @param string $title The title of the worksheet
     *
     * @return boolean
     */
    protected function isExcludedWorksheet($title)
    {
        if (!isset($this->options['exclude_worksheets'])) {
            return false;
        }

        foreach ($this->options['exclude_worksheets'] as $regexp) {
            if (preg_match($regexp, $title)) {
                return true;
            }
        }

        return false;
    }

    protected function createValuesIterator()
    {
        $sheet = $this->worksheetIterator->current();
        $this->rows = $sheet->getRowIterator();
        $this->rows->rewind();
        while ($this->rows->valid() && ((int) $this->options['label_row'] > $this->rows->key())) {
            $this->rows->next();
        }
        $this->headers = $this->rows->current();
        while ($this->rows->valid() && ((int) $this->options['data_row']  > $this->rows->key())) {
            $this->rows->next();
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'skip_empty' => false,
                'label_row'  => 1,
                'data_row'   => 2,
            ]
        );

        $resolver->setDefined([
            'include_worksheets',
            'exclude_worksheets',
        ]);
    }
}
