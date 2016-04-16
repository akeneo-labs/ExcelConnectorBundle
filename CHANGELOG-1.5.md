# CHANGELOG 1.5

## 1.5.3

### Improvement
- EX-24: allow import numeric values for text and textarea attributes


## 1.5.2

### Bug fix
 - EX-22: Fix associations in product import

### Improvement
 - The product XLSX import don't rely anymore to the deprecated import services


## 1.5.1 (2015-10-13)

### Bug fix
 - EX-17: Allow init import and product import having numeric identifier

### BC break
 - Inject `pim_catalog.repository.attribute` inside `pim_excel_connector.reader.spreadsheet` with `setAttributeRepository` method


## 1.5.0 (2015-10-07)
 - Migrate bundle to AkeneoLabs
