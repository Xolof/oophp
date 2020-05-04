<?php
namespace Anax\View;

?>

<form method="post">
    <p>
        <label>Movie:<br>
        <select name="movieId">
            <option value="">Select movie...</option>
            <?php foreach ($movies as $movie) : ?>
            <option value="<?= e($movie->id) ?>"><?= e($movie->title) ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    </p>

        <input type="submit" name="doEdit" value="Edit selected"  class="btn_movie btn_edit_movie">
        <input type="submit" name="doDelete" value="Delete selected" class="btn_movie btn_delete_movie">

        <p>or</p>
        <input type="submit" name="doAdd" value="Add a new movie" class="btn_movie btn_add_movie">
</form>
