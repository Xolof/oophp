<?php
namespace Anax\View;

if (!$res) {
    return;
}
?>

<?php foreach ($res as $row) : ?>
<table>
    <tr>
        <th>Id</th>
        <td><?= e($row->id) ?></td>
    </tr>
    <tr>
        <th>Title</th>
        <td><?= e($row->title) ?></td>
    </tr>
    <tr>
        <th>Type</th>
        <td><?= e($row->type) ?></td>
    </tr>
    <tr>
        <th>Published</th>
        <td><?= e($row->published) ?></td>
    </tr>
    <tr>
        <th>Created</th>
        <td><?= e($row->created) ?></td>
    </tr>
    <tr>
        <th>Updated</th>
        <td><?= e($row->updated) ?></td>
    </tr>
    <tr>
        <th>Deleted</th>
        <td><?= e($row->deleted) ?></td>
    </tr>
    <tr>
        <th>Actions</th>
        <td class="actionsTd">
            <a href=<?= "edit?id={$row->id}" ?>>Edit</a>
            <a class="delete-cross" href=<?= "delete?id={$row->id}" ?>>&#10005;</a>
        </td>
    </tr>
</table>
<?php endforeach; ?>