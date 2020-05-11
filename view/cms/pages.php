<?php
namespace Anax\View;

if (!$res) {
    return;
}
?>

<table>
    <tr class="first">
        <th>Id</th>
        <th>Title</th>
        <th>Type</th>
        <th>Status</th>
        <th>Published</th>
        <th>Deleted</th>
    </tr>
<?php $id = -1; foreach ($res as $row) :
    $id++; ?>
    <tr>
        <td><?= $row->id ?></td>
        <td><a href="page/<?= e($row->path) ?>"><?= e($row->title) ?></a></td>
        <td><?= e($row->type) ?></td>
        <td><?= e($row->status) ?></td>
        <td><?= e($row->published) ?></td>
        <td><?= e($row->deleted) ?></td>
    </tr>
<?php endforeach; ?>
</table>
