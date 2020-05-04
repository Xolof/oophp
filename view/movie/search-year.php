<form method="get">
    <!-- <input type="hidden" name="route" value="search-year"> -->
    <p>
        <label class="year_label_movie">Created between:

        <input type="number" name="year1" value="<?= $year1 ?: 1900 ?>" min="1900" max="2100"/>
        - 
        <input type="number" name="year2" value="<?= $year2  ?: 2100 ?>" min="1900" max="2100"/>
        </label>
    </p>
    <p>
        <input class="btn_movie btn_search_movie" type="submit" value="Search">
        <!-- name="doSearch"-->
    </p>
    <p><a href="?year1=1900&year2=2100">Show all</a></p>
</form>
