# Attributes tab

In this tab you can define every attribute depending wether they belong to one or more families. If the attribute is only part of one family, consider defining it directly in the corresponding family tab.

See [family tab section](https://github.com/akeneo/ExcelConnectorBundle/wiki/Families) to know how to do this.

For more details about the keys concept of attribute, see [attribute in the user guide](http://www.akeneo.com/doc/user-guide/key-concepts/attributes/).

## General properties

### Attribute code
Attribute code must be only composed of letters, numbers, spaces and underscores. No other character will be accepted.

### Label columns
These columns allows you to define localized label for your attribute. You will have to add one column per locale. Be sure there are grouped below the **Labels** section (line #4) like this:
<table>
<header>
<tr><td rowspan="2">Attribute code</td>
<td colspan="3">Labels</td></tr>
<tr>
<td>en_US</td>
<td>es_ES</td>
<td>fr_FR</td>
</tr>
<tr><td>code<td>label-en_US</td><td>label-fr_FR</td><td>label-es_ES</td></tr>
</header>
<tbody>
<tr>
<td>color</td>
<td>Color</td>
<td>Couleur</td>
<td>Color</td>
</tr>
</tbody>
</table>

**Note** : labels must be under 255 characters.

### Attribute type
Attribute type can be:
`Identifier`, `Text`, `Text area`, `Multiple select`, `Simple select`, `Price collection`, `Number`, `Boolean`, `Date`, `File`, `Image` and `Metric`.

These type are definded in the hidden [attribute type tab](https://github.com/akeneo/ExcelConnectorBundle/wiki/Attribute-types) attribute_type. If you are using the [CustomEntityBundle](https://github.com/akeneo/CustomEntityBundle), this is where you will have to add your new attribute type.

### Attribute group
Select here the associated attribute group code. Attributes codes are defined in the [attribute groups](https://github.com/akeneo/ExcelConnectorBundle/wiki/Attribute-groups) tab.

### Sort order
The sort order is an integer defining the display order in the attribute group on the product edit form.

### Is unique
Choose if the attribute must have unique values.

### Is localizable
Choose if the attribute is localizable or not.

### Specific to locales
Define here the list of comma-separated locales.

### Is scopable
Choose if the attribute is scopable or not.

### Minimum input length
Determines how many characters should be typed for select attributes before an option is presented.
This should be used for attributes which have a large number of options

### Useable as grid filter
Choose if the attribute is useabe as grid filter or not.

## Properties for text attributes
### Max characters
Max characters is an integer defining how many characters maximum can be entered in a text field.

### Validation rule
Validation rule can be `email`, `url` or `regexp`.

### Validation regexp
If validation rule is *regexp*, use this column to define the regular expression that will be used for validation.

### Rich text
Choose if the text field will be using a [TinyMCE WYSIWYG editor](http://www.tinymce.com/), allowing rich text possibilities.

## Properties for number attributes
### Minimum number
Specify here the minimum number.

### Maximum number
Specify here the maximum number.

### Decimals allowed
Specify here if the numbers can only be integers or not.

### Negative allowed
Specify here if negative numbers are allowed.

## Properties for date attributes
### Minimum date
Specify here the minimum date users can input.

### Maximum date
Specify here the maximum date users can input.

## Properties for metric attributes
### Metric family
Choose here the metric family. Available options are: `Area`, `Binary`, `Frequency`, `Length`, `Power`, `Speed`, `Temperature`, `Volume`, `Weight`.

Metric families are defined in the hidden [metric types](https://github.com/akeneo/ExcelConnectorBundle/wiki/Metric-types) tab.

### Default metric  unit
Choose here the default metric unit.

Metric units are defined in the hidden [metric units](https://github.com/akeneo/ExcelConnectorBundle/wiki/Metric-units) tab.

## Properties for file attributes
### Max file size
Define here the maximum file size in MB.

### Allowed extensions
Insert the allowed extensions, separated by a comma.

For example : `jpg`, `jpeg`, `png` or `pdf`.
