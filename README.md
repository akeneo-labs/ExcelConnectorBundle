Akeneo Excel Connector Bundle
=============================

This bundle contains utility classes used to create Excel connectors.
It also provides a method to initiate the PIM with a single Excel file.

[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/akeneo/ExcelConnectorBundle/badges/quality-score.png?s=9732bdac97b997021b1c925f923ecbf405a509d4)](https://scrutinizer-ci.com/g/akeneo/ExcelConnectorBundle/)

Installing the bundle
---------------------
From your application root:

    $ php composer.phar require --prefer-dist "akeneo/excel-connector-bundle"

Register the bundle by adding the following line inside the `app/AppKernel.php` file, just before the "return $bundles;" line:

    $bundles[] = new Pim\Bundle\ExcelConnectorBundle\PimExcelConnectorBundle();


Initializing the PIM with an Excel file
---------------------------------------

To initialize the PIM with an Excel file, use the following steps :

 * Copy the Resources/fixtures/minimal folder inside the Resources/fixtures folder of one of your bundles.
 * Edit the init.xlsx file to your needs
 * Define the data used by the installer in the parameters.yml file:

    installer_data: 'AcmeDemoBundle:minimal'

The init.xlsx file can also be loaded in the following ways :

 * individually by using the pim:installer:load-fixtures command.
 * using the "Initialisation import" from the "Akeneo Excel Connector"

