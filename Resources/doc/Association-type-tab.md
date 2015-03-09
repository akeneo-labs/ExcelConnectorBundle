# Association type tab

See [user guide](http://www.akeneo.com/doc/user-guide/key-concepts/association/) to know more about association types.

## Association type code
Specify here a code for your association type. Association type code must be only composed of letters, numbers, spaces and underscores. No other character will be accepted.

Example: `X_SELL`, `UPSELL`, `SUBSTITUTION`, `PACK`.

## Labels
These columns allows you to define localized label for your attribute. You will have to add one column per locale. Be sure they are grouped below the Labels section (line #1).

**Example:**
<table>
<header>
<tr><td rowspan="2">Association type properties</td>
<td colspan="3">Labels</td></tr>
<tr>
<td>label-en_US</td>
<td>label-es_ES</td>
<td>label-fr_FR</td>
</tr>
<tr>
<td>Association type code</td><td>en_US</td><td>fr_FR</td><td>es_ES</td></tr>
</header>
<tbody>
<tr>
<td>X_SELL</td>
<td>Cross sell</td>
<td>Vente croisée</td>
<td>Venta cruzada</td>
</tr>
</tbody>
</table>
