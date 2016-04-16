# CHANGELOG 1.4

## 1.4.1 (2015-10-13)
### Bug fix
 - EX-17: Allow init import and product import having numeric identifier

### BC break
 - Inject `pim_catalog.repository.attribute` inside `pim_excel_connector.reader.spreadsheet` with `setAttributeRepository` method

## 1.4.0 (2015-03-17)
 - Made compatible with PIM CE 1.3.x
 - Updated the init file from fixtures:
    - Removed default_value and usable_as_grid_column from attributes and family tab
    - Corrected the codes for wysywig_enabled and available_locales in the attributes and family tab
    - Removed the is_default column from the options tab
    - Removed garbage characters
