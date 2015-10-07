<?php

namespace Pim\Bundle\ExcelConnectorBundle\Archiver;

use Akeneo\Bundle\BatchBundle\Entity\JobExecution;
use Akeneo\Bundle\BatchBundle\Step\ItemStep;
use League\Flysystem\Filesystem;
use Pim\Bundle\BaseConnectorBundle\Archiver\AbstractFilesystemArchiver;
use Pim\Bundle\ExcelConnectorBundle\Reader\FileIteratorReader;

/**
 * Archive job execution files into conventional directories
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2014 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class FileIteratorReaderArchiver extends AbstractFilesystemArchiver
{
    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(JobExecution $jobExecution)
    {
        return true;
    }

    /**
     * Archive files used by job execution (input / output)
     *
     * @param JobExecution $jobExecution
     */
    public function archive(JobExecution $jobExecution)
    {
        foreach ($jobExecution->getJobInstance()->getJob()->getSteps() as $step) {
            if (!$step instanceof ItemStep) {
                continue;
            }
            $reader = $step->getReader();

            if ($reader instanceof FileIteratorReader) {
                $key = strtr(
                    $this->getRelativeArchivePath($jobExecution),
                    [
                        '%filename%' => basename($reader->getFilePath()),
                    ]
                );
                $this->filesystem->put($key, file_get_contents($reader->getFilePath()));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'excel_input';
    }
}
