<?php
namespace Anax\View;

?>

<article>
        <h1><?= e($content->title) ?></h1>
        <p><i>Published: <time datetime="<?= e($content->published_iso8601) ?>" pubdate><?= e($content->published) ?></time></i></p>
    <?= $content->data ?>
</article>