<?php
namespace Anax\View;

?>

<table class="table_movie">
    <tr class="first">
        <th>Id</th>
        <th>Bild</th>
        <th>Titel</th>
        <th>År</th>
    </tr>

    <tr>
        <td><?= e($movie->id) ?></td>
        <td><img class="thumb" src="<?= e(asset("image/movie/" . $movie->image . "?w=200")) ?>"></td>
        <td><?= e($movie->title) ?></td>
        <td><?= e($movie->year) ?></td>
    </tr>

</table>
