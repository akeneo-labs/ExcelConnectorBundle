<?php

namespace Pim\Bundle\ExcelConnectorBundle\Reader;

use Pim\Bundle\CatalogBundle\Validator\Constraints\File as AssertFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * XLSX file reader
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class XlsxFileReader extends FileIteratorReader
{
    /**
     * @Assert\NotBlank(groups={"Execution"})
     * @AssertFile(
     *     groups={"Execution"},
     *     allowedExtensions={"xlsx", "xlsm", "csv"},
     * )
     */
    protected $filePath;

    /**
     * {@inheritdoc}
     */
    public function getUploadedFileConstraints()
    {
        return array(
            new Assert\NotBlank(),
            new AssertFile(
                array(
                    'allowedExtensions' => array('xlsx', 'xlsm', 'csv'),
                    'mimeTypes'         => array(
                        'text/csv',
                        'application/vnd.ms-excel',
                        'application/zip',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    )
                )
            )
        );
    }
}
