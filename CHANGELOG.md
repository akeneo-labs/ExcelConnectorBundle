# CHANGELOG

## 1.5.0 (2015-10-xx)
 - Migrate bundle to AkeneoLabs
 
## 1.4.1
### Bug fix
 - Allow init import and product import having numeric identifier

### BC break
 - Inject `pim_catalog.repository.attribute` inside `pim_excel_connector.reader.spreadsheet` with `setAttributeRepository` method

## 1.4.0 (2015-03-17)
 - Made compatible with PIM CE 1.3.x
 - Updated the init file from fixtures:
    - Removed default_value and usable_as_grid_column from attributes and family tab
    - Corrected the codes for wysywig_enabled and available_locales in the attributes and family tab
    - Removed the is_default column from the options tab
    - Removed garbage characters

## 1.3.2 (2014-09-25)
 - Added compatibility with PIM CE 1.2.6

## 1.3.1 (2014-09-22)
 - Fixed write count for homogeneous CSV writer

## 1.3.0 (2014-09-11)
 - Added SpreadsheetReader, for compatibility with all formats supported by Akeneo Spreadsheet parser
 - Compatibility with version 1.2 of Akeneo PIM CE
 - Removed content type constraint on readers
 - pim_excel_connector.reader.xls_init service was renamed pim_excel_connector.reader.xls

## 1.2.0 (2014-05-14)
- Added support for Akeneo Spreadsheet parser

## 1.1.0 (2014-04-16)
- Added Office XML 2003 export
- Compatibility with version 1.1 of Akeneo PIM

## 1.1.0 (2014-03-07)
 - Initial release.
