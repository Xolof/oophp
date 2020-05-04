<?php
namespace Anax\View;

// echo showEnvironment(get_defined_vars(), get_defined_functions());
?>

<form method="get">

    <!-- <input type="hidden" name="route" value="search-title"> -->
    <p>
        <label for="searchTitle">Title (use % as wildcard):</label>
        <input type="search" name="searchTitle" value="<?= $searchTitle ?>"/>
    </p>
    <p>
        <input class="btn_movie btn_search_movie" type="submit" value="Search">
        <!-- name="doSearch" -->
    </p>
    <p><a href="?searchTitle=%25">Show all</a></p>
</form>
