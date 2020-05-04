<?php
/**
 * Show all movies.
 */
$app->router->get("mtest", function () use ($app) {
    $title = "Movie database | oophp";

    $app->db->connect();
    $sql = "SELECT * FROM movie;";
    $res = $app->db->executeFetchAll($sql);

    $app->page->add("mtest/index", [
        "res" => $res,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});
