<?php
namespace Anax\View;

?>

<article>
        <h1><?= e($content->title) ?></h1>
        <p><i>Latest update: <time datetime="<?= e($content->modified_iso8601) ?>" pubdate><?= e($content->modified) ?></time></i></p>
    <?= $content->data ?>
</article>