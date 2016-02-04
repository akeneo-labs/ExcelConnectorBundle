# Akeneo Excel Connector Bundle

This bundle adds support of Excel XSLX files as a source for initialization catalog structure and import/export of products for [Akeneo PIM](https://github.com/akeneo/pim-community-standard).

[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/akeneo/ExcelConnectorBundle/badges/quality-score.png?s=9732bdac97b997021b1c925f923ecbf405a509d4)](https://scrutinizer-ci.com/g/akeneo/ExcelConnectorBundle/)

## Requirements

| ExcelConnectorBundle | Akeneo PIM Community Edition |
|:--------------------:|:----------------------------:|
| v1.5.*               | v1.4.*                       |
| v1.4.*               | v1.3.*                       |
| v1.3.*               | v1.2.*                       |
| v1.1.\*, v1.2.\*     | v1.1.\*                      |
| v1.0.*               | v1.0.*                       |

## Installation

From your application root:

    $ php composer.phar require --prefer-dist akeneo-labs/excel-connector-bundle:1.5.*

If you want to use the development version (only for test purpose, do not use it in production), replace "1.5.*" by "dev-master" in the previous command.

Register the bundle by adding the following lines:

    /* app/AppKernel.php */

    // ...
    protected function getPimDependenciesBundles()
    {
        return [
            // ...
            new Akeneo\Bundle\SpreadsheetParserBundle\AkeneoSpreadsheetParserBundle(),
            new Pim\Bundle\ExcelConnectorBundle\PimExcelConnectorBundle()
        ];
    }

Then clean the cache and reinstall the assets:

    php app/console cache:clear --env=prod
    
    php app/console pim:install:assets --env=prod

## Documentation

See [Resources/doc folder](./Resources/doc/Home.rst) for more details on how to set your catalog structure
using the [init.xslx](./Resources/fixtures/minimal/init.xlsx) file.

## Supported file

Input file must follow [init.xslx](./Resources/fixtures/minimal/init.xlsx) structure.
Note that the file must be opened with Excel. LibreOffice/OpenOffice are not in compliance with validations data 
that are available in the spreadsheet.

## Importation job

This bundle allows you to import products file directly in the UI through Import > Import jobs.
Note the init.xlsx import is available in this UI. It should not be used as import (only as initialization file).

## Dependencies

This bundles uses [phpoffice/phpexcel](https://github.com/PHPOffice/PHPExcel) and [akeneo-labs/spreadsheet-parser-bundle](https://github.com/akeneo-labs/spreadsheet-parser).
