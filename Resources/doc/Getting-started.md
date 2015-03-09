# Getting started

## Installing the bundle

From your application root:

    $ php composer.phar require --prefer-dist "akeneo/excel-connector-bundle"

Register the bundle by adding the following lines:

```php
<?php /* app/AppKernel.php */

    // ...
    protected function getPimDependenciesBundles()
    {
        return [
            // ...
            new Akeneo\Bundle\SpreadsheetParserBundle\AkeneoSpreadsheetParserBundle(),
            new Pim\Bundle\ExcelConnectorBundle\PimExcelConnectorBundle()
        ];
    }
```


## Initializing the PIM with a XLSX file


### Create an InstallerBundle

You can create your own InstallerBundle by following the instructions from the documentation : http://docs.akeneo.com/1.3/cookbook/setup_data/customize_installer.html

### Copy the fixtures
All minimal fixtures are located in the **Resources/fixtures/minimal** folder inside the **ExcelConnectorBundle**.

All these fixtures can't be set in the init.xslx files. Be sure to use the very same name/code in both the init.xslx files and the YML files.

Place them in the same directory inside your InstallerBundle. Here is a description of what each files contains:

#### CE edition

| File                   | Description
| -------------------- | ---
| **currencies.yml**  | Contains all curencies used (and the ones that are removed)
| **init.xslx**  | Contains the whole Catalog description, see init.xslx structure below
| **locales.yml**   | Define the used locales and their currency
| **user_groups.yml**  | Define all user groups (code + label)
| **user_roles.yml**   | Define all user roles (code + label)
| **users.yml** | Define users list

You can still have a look on the [Akeneo PIM  minimal fixtures](https://github.com/akeneo/pim-community-dev/tree/master/src/Pim/Bundle/InstallerBundle/Resources/fixtures/minimal) set to get a full list of the files and their expected format.


#### EE edition (incl. CE files)
EE edition adds support of ACL, please refer to the minimal fixtures set located in the InstallerBundle to see the structure and the content of the files.
Note that you cannot define ACL in the init.xslx file and will have to define them in seperatly

| File                   | Description
| -------------------- | ---
| **attribute_groups_accesses.yml**  | Contains ACL for attribute groups
| **category_accesses.yml**  | Contains ACL for  categories
| **locale_accesses.yml**   | Contains ACL for locales


### Customize init.xslx !

Edit the init.xlsx file to your needs following the instructions inside the file itself.
The file is composed of various tabs that allow you to set your catalog structures :
- channels
- categories
- group types
- association types
- attributes
- attribute groups
- attribute options
- families (as many tabs as required)

See [tab description section](Home.md#define-the-structure-of-your-catalog) for more details on how to customize the init.xslx file.

### Change PIM parameter to use your custom installation

```yml
parameters:
    pim_installer.fixture_loader.job_loader.config_file: 'PimExcelConnectorBundle/Resources/config/fixtures_jobs.yml'
```
### Define the data used by the installer :

```yml
# app/config/pim_parameters.yml
parameters:
    ...
    installer_data: 'AcmeDemoBundle:minimal'
```
