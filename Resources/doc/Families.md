# Family tabs

Case of families is special because you will have as many family tabs as you have families. Each of them must be named like `family family_code`.

Another particularity is than you can define attributes in this tab just the way it is achieved in the [attribute tab](https://github.com/akeneo/ExcelConnectorBundle/wiki/Attributes). Common columns between families tabs and attriubte tab won't be explained.
Please refer [attribute tab](https://github.com/akeneo/ExcelConnectorBundle/wiki/Attributes) for more details.

Attributes defined here will be useable in every family.

If your attributes are defined in the attribute tab, you will only have to fill **Attribute code**, **Use as label**, and **Completeness columns**. Just be sure not to define more than once your attribute. An error message will be triggered otherwise.

Also note that you can mix full attribute definition and attribute list in this tab.

## Family code
Family codes must be only composed of letters, numbers, spaces and underscores. No other character will be accepted.

## Localized label
You can specify a different label for each locale.
<table>
<header>
<tr><td></th>
<th>en_US</th>
<th>fr_FR</th>
<th>es_ES</th>
</tr>
</header>
<tbody>
<tr>
<th>Label</th>
<td>Main</td>
<td>Principal</td>
<td>Principal</td>
</tbody>
</tbody>
</table>

## Attribute code
See [attribute code](https://github.com/akeneo/ExcelConnectorBundle/wiki/Attributes#attribute-code) in the attribute tab.

## Use as label
Indicate (`0`/`1`) whether or not the attribute should be used as a label for the family. Note that this only concern text attributes.

## Completeness channel_code
Define here if the attribute is part of the completeness calculation for the channel_code channel. Channels are defined in the [channel tab](https://github.com/akeneo/ExcelConnectorBundle/wiki/Channels-tab). Learn more about completeness in the [user guide](http://www.akeneo.com/doc/user-guide/key-concepts/completeness/).

You will have to add as many Completeness column as you have channels.
