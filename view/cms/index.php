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
        <th>Published</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Deleted</th>
    </tr>
<?php foreach ($res as $row) : ?>
    <tr>
        <td><?= e($row->id) ?></td>
        <td><?= e($row->title) ?></td>
        <td><?= e($row->type) ?></td>
        <td><?= e($row->published) ?></td>
        <td><?= e($row->created) ?></td>
        <td><?= e($row->updated) ?></td>
        <td><?= e($row->deleted) ?></td>
    </tr>
<?php endforeach; ?>
</table>