<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Represents an XLSX Archive
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Archive
{

    const TEMP_SUBFOLDER = '/xlsx_extract/';

    /**
     *
     * @var string
     */
    protected $tempPath;

    /**
     *
     * @var string
     */
    protected $archivePath;

    /**
     * Constructor
     *
     * @param string $archivePath
     */
    public function __construct($archivePath)
    {
        $this->archivePath = $archivePath;
        $this->tempPath = sys_get_temp_dir() . self::TEMP_SUBFOLDER;
    }

    /**
     * Extracts the specified file to a temp path, and return the temp path
     *
     * Files are only extracted once for the given archive
     *
     * @param string $filePath
     *
     * @return string
     */
    public function extract($filePath)
    {
        $zip = new \ZipArchive();

        if (true === $zip->open($this->archivePath)) {

            $zip->extractTo($this->tempPath, $filePath);
            $zip->close();
        } else {

            throw new \Exception('Error opening file');
        }

        return $this->tempPath . $filePath;
    }

    /**
     * Clears all extracted files
     */
    public function __destruct()
    {
        $fs = new Filesystem();
        $fs->remove($this->tempPath);
    }

}
