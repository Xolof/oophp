<?php
namespace Anax\View;

?>

<article class="article_movie">

<h1 class="header_movie">My Movie Database</h1>

<navbar class="navbar_movie">
    <!-- <a href="?route=select">SELECT *</a> -->
    <a href="show">Show all movies</a>
    <!-- <a href="?route=reset">Reset database</a> -->
    <a href="searchtitle">Search title</a>
    <a href="searchyear">Search year</a>
    <a href="edit">Edit</a>
    <!-- <a href="?route=show-all-sort">Show all sortable</a> -->
    <!-- <a href="?route=show-all-paginate">Show all paginate</a> -->
</navbar>

<?php

$msg = $app->session->getOnce("message");
if ($msg) {
    echo "<p class='info_movie'>" . e($msg) . "</p>";
}

if ($warning) {
    echo "<p class='warning_movie'>" . e($warning) . "</p>";
}
?>
