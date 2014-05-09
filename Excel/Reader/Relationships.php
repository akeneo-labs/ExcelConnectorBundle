<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

/**
 * Workbook relationships
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Relationships extends AbstractXMLResource
{

    /**
     *
     * @var string
     */
    protected $relationshipsPath;

    /**
     *
     * @var array
     */
    protected $workSheetPaths;

    /**
     *
     * @var string
     */
    protected $stylePath;

    /**
     *
     * @var string
     */
    protected $sharedStringPath;

    /**
     * Constructor
     *
     * @param string $relationshipsPath the path to the XML relationships file
     */
    public function __construct($relationshipsPath)
    {
        parent::__construct($relationshipsPath);
        $this->relationshipsPath = $relationshipsPath;

        $this->readRelationShips();
    }

    /**
     * Returns the path of a worksheet file inside the xlsx file
     *
     * @param string $id
     *
     * @return string
     */
    public function getWorksheetPath($id)
    {
        return $this->workSheetPaths[$id];
    }

    /**
     * Returns the path of the shared strings file inside the xlsx file
     *
     * @return string
     */
    public function getSharedStringsPath()
    {
        return $this->sharedStringPath;
    }

    /**
     * Returns the path of the styles XML file inside the xlsx file
     *
     * @return string
     */
    public function getStylesPath()
    {
        return $this->stylePath;
    }

    /**
     * Reads the entire relationShips file once
     */
    private function readRelationShips()
    {
        $xml = $this->getXMLReader($this->relationshipsPath);

        while ($xml->read()) {
            if (\XMLReader::ELEMENT === $xml->nodeType && 'Relationship' === $xml->name) {

                $type = basename((string) $xml->getAttribute('Type'));
                $this->storeRelationShipByType($type, $xml->getAttribute('Id'), 'xl/' . $xml->getAttribute('Target'));
            }
        }

        $this->closeXMLReader();
    }

    /**
     * stores the relationShip into the right variable
     *
     * @param string $type
     * @param string $id
     * @param string $target
     */
    private function storeRelationShipByType($type, $id, $target)
    {
        switch ($type) {
            case 'worksheet' :
                $this->workSheetPaths[$id] = $target;
                break;
            case 'styles' :
                $this->stylePath = $target;
                break;
            case 'sharedStrings' :
                $this->sharedStringPath = $target;
                break;
        }
    }

}
