<?php
namespace Anax\View;

?>

<h1>Landing</h1>
<article class="article_landing">
    <section class="landing_section">
        <h3><a href="<?= url('cms/pages')?>">Pages</a></h3>
        <nav>
        <?php foreach ($res as $item) : ?>
            <?php if ($item->type === "page") : ?>
                <a href="page/<?= e($item->path) ?>"><?= e($item->title) ?></a>
            <?php endif; ?>
        <?php endforeach ?>
        </nav>
    </section>

    <section class="landing_section">
        <h3><a href="<?= url('cms/blog')?>">Blogposts</a></h3>
        <nav>
        <?php foreach ($res as $item) : ?>
            <?php if ($item->type === "post") : ?>
                <a href="blogpost/<?= e($item->slug) ?>"><?= e($item->title) ?></a>
            <?php endif; ?>
        <?php endforeach ?>
        </nav>
    </section>
</article>
