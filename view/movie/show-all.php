<?php
namespace Anax\View;

if (!$resultset) {
    return;
}
?>

<table class="table_movie">
    <tr class="first">
        <th>Rad</th>
        <th>Id</th>
        <th>Bild</th>
        <th>Titel</th>
        <th>År</th>
    </tr>
<?php $id = -1; foreach ($resultset as $row) :
    $id++; ?>
    <tr>
        <td><?= e($id) ?></td>
        <td><?= e($row->id) ?></td>
        <td><img class="thumb" src="<?= e(asset("image/movie/" . $row->image . "?w=200")) ?>"></td>
        <td><?= e($row->title) ?></td>
        <td><?= e($row->year) ?></td>
    </tr>

<?php endforeach; ?>

</table>
