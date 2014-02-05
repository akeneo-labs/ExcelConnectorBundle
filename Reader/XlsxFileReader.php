<?php

namespace Pim\Bundle\ExcelConnectorBundle\Reader;

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
     *     allowedExtensions={"xlsx"},
     *     mimeTypes={
     *         "application/vnd.ms-excel",
     *         "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
     *     }
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
                    'allowedExtensions' => array('csv', 'zip'),
                    'mimeTypes'         => array(
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    )
                )
            )
        );
    }
}
