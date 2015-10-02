# Akeneo Excel Connector Bundle

This bundle adds support of Excel XSLX files as a source for initialization and importation of catalog structure for [Akeneo PIM](https://github.com/akeneo/pim-community-standard).

[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/akeneo/ExcelConnectorBundle/badges/quality-score.png?s=9732bdac97b997021b1c925f923ecbf405a509d4)](https://scrutinizer-ci.com/g/akeneo/ExcelConnectorBundle/)

# Documentation

See [Resources/doc folder](./Resources/doc/Home.rst) for more details on how to set your catalog structure
using the [init.xslx](./Resources/fixtures/minimal/init.xlsx) file.

# Supported file

Input file must follow [init.xslx](./Resources/fixtures/minimal/init.xlsx) structure.
Note that the file must be opened with Excel. LibreOffice/OpenOffice are not in compliance with validations data 
that are available in the spreadsheet.

# Importation job

This bundle allows you to import the [init.xslx](./Resources/fixtures/minimal/init.xlsx) file directly
in the UI through Import > Import jobs.

# Dependencies

This bundles uses [phpoffice/phpexcel](https://github.com/PHPOffice/PHPExcel) and [akeneo-labs/spreadsheet-parser-bundle](https://github.com/akeneo-labs/spreadsheet-parser).
