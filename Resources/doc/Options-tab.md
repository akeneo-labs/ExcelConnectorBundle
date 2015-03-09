# Attribute options tab

Attributes options are the possibilities of choices for simple and multi select attributes.

## Attribute code
Specify here the attribute code for which you want to append the option.

## Option code
Specify here a code for your attribute option. Attribute option codes must be only composed of letters, numbers, spaces and underscores. No other character will be accepted.

Examples: `blue`, `XL`, `silk`.

## Localizable labels

These columns allows you to define localized label for your attribute. You will have to add one column per locale. Be sure they are grouped below the Labels section (line #1).

The 3rd line is hidden, you will have to show it if you want to add other locales. The following example assume you are showing this line.

**Example:**
<table>
<header>
<tr><td rowspan="2" colspan="2">Option properties</td>
<td colspan="3">Labels</td></tr>
<tr>
<td>label-en_US</td>
<td>label-es_ES</td>
<td>label-fr_FR</td>
</tr>
<tr>
<td>Attribute code</td><td>Option code</td><td>en_US</td><td>fr_FR</td><td>es_ES</td></tr>
</header>
<tbody>
<tr>
<td>color</td>
<td>blue</td>
<td>Blue</td>
<td>Bleu</td>
<td>Azul</td>
</tr>
<tr>
<td>color</td>
<td>red</td>
<td>Red</td>
<td>Rouge</td>
<td>Rojo</td>
</tr>
</tbody>
</table>
