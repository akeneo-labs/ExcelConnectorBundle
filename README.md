# ExcelConnectorBundle

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/akeneo-labs/ExcelConnectorBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/akeneo-labs/ExcelConnectorBundle/?branch=master)
[![Build Status](https://travis-ci.org/akeneo-labs/ExcelConnectorBundle.svg?branch=master)](https://travis-ci.org/akeneo-labs/ExcelConnectorBundle)

![alt text](./Resources/doc/pictures/akeneo_excel.png "")

This bundle adds support of Excel XSLX files as a source for initializing catalog structure and import/export of products for [Akeneo PIM](https://github.com/akeneo/pim-community-standard).

## Requirements

| ExcelConnectorBundle | Akeneo PIM Community Edition |
|:--------------------:|:----------------------------:|
| v1.6.*               | v1.5.*                       |
| v1.5.*               | v1.4.*                       |
| v1.4.*               | v1.3.*                       |
| v1.3.*               | v1.2.*                       |
| v1.1.\*, v1.2.\*     | v1.1.*                       |
| v1.0.*               | v1.0.*                       |

## Installation

From your application root:

```bash
    $ php composer.phar require --prefer-dist akeneo-labs/excel-connector-bundle:1.6.*
```

Enable the bundle in the `app/AppKernel.php` file in the `registerBundles()` method:

```php
    $bundles = [
        // ...
        new Akeneo\Bundle\SpreadsheetParserBundle\AkeneoSpreadsheetParserBundle(),
        new Pim\Bundle\ExcelConnectorBundle\PimExcelConnectorBundle(),
    ]
```

Then clean the cache and reinstall the assets:

```bash
    php app/console cache:clear --env=prod

    php app/console pim:install:assets --env=prod
```

## Documentation

### Getting started

See [Resources/doc/Getting started](./Resources/doc/Getting-started.rst) for more details on how to set your catalog structure
using the [init.xslx](./Resources/fixtures/minimal/init.xlsx) file.

See [Resources/doc folder](./Resources/doc/Home.rst) for more details on how to set your catalog structur

### Supported file

Input file must follow [init.xslx](./Resources/fixtures/minimal/init.xlsx) structure.
Note that the file must be opened with Excel. LibreOffice/OpenOffice are not in compliance with validations data
that are available in the spreadsheet.

### Importation job

This bundle allows you to import products files directly in the UI through Import > Import jobs.
Please note that the init.xlsx import is also available via the UI. However, it should not be used as an import system for entities available within this file (families, categories, etc.) once the catalog structure has been set.


## Troubleshooting

###The import fails when importing families

Check that your channels names are correct in both family and channel tabs. You might have a typo in the channels tab and not in the family tab. You will have to remove the mispelled channel once you corrected this.
