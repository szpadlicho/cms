<? include 'templates/header.html.php'; ?></pre>
<h1>Lista kategorii</h1>
<? foreach($this->get('catsData') as $cats) { ?> <? } ?>
<table>
<tbody>
<tr>
<td>Nazwa</td>
<td></td>
</tr>
<tr>
<td></td>
<td><a href="?task=categories&action=delete&id=<? $cats['id']; ?>">usuń</a></td>
</tr>
</tbody>
</table>

<pre>
<? include 'templates/footer.html.php'; ?>