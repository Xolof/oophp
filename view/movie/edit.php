<?php
namespace Anax\View;

?>

<form method="post">
    <fieldset>
    <legend>Edit</legend>
    <input type="hidden" name="movieId" value="<?= e($movie->id) ?>"/>

    <p>
        <label>Title:<br> 
        <input type="text" name="movieTitle" value="<?= e($movie->title) ?>"/>
        </label>
    </p>

    <p>
        <label>Year:<br> 
        <input type="number" name="movieYear" value="<?= e($movie->year)?>" min="1900" max="2100"/>
    </p>

    <p>
        <label>Image:<br> 
        <input type="text" name="movieImage" value="<?= e($movie->image) ?>"/>
        </label>
    </p>

    <p>
        <input type="submit" name="doSave" value="Save" class="btn_movie btn_edit_movie">
        <input type="reset" value="Reset" class="btn_movie btn_reset_movie">
    </p>
    </fieldset>
</form>
