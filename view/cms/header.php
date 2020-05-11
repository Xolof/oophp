<?php
namespace Anax\View;

?>

<header class="site-header">
    <h1>My CMS</h1>

    <navbar class="navbar">
        <a href="<?= url('cms/landing')?>">Landing</a> |
        <a href="<?= url('cms/show')?>">Show all content</a> |
        <a href="<?= url('cms/admin')?>">Admin</a> |
        <a href="<?= url('cms/create')?>">Create</a> |
        <a href="<?= url('cms/pages')?>">Pages</a> |
        <a href="<?= url('cms/blog')?>">Blog</a> |
        <a href="<?= url('cms/reset')?>">Reset</a> |
    </navbar> 
</header>

<main class="main_myCMS">
