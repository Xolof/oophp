<?php
namespace Anax\View;

if (!$res) {
    return;
}
?>

<?php foreach ($res as $row) : ?>
    <section class="cms_content_item">
        <p><b>Id:</b> <?= e($row->id) ?></p>
        <p><b>Title:</b> <?= e($row->title) ?></p>
        <p><b>Type:</b> <?= e($row->type) ?></p>
        <p><b>Published:</b> <?= e($row->published) ?></p>
        <p><b>Created:</b> <?= e($row->created) ?></p>
        <p><b>Updated:</b> <?= e($row->updated) ?></p>
        <p><b>Deleted:</b> <?= e($row->deleted) ?></p>
        <p><b>Path:</b> <?= e($row->path) ?></p>
        <p><b>Slug:</b> <?= e($row->slug) ?></p>
    </section>


<?php endforeach; ?>
