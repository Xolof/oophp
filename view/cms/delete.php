<?php
namespace Anax\View;

?>

<form method="post" action="dodelete">
    <fieldset>
    <legend>Do you really wish to delete this content?</legend>

    <input type="hidden" name="contentId" value="<?= e($content->id) ?>"/>

    <p>
        <label>Title:<br> 
            <input type="text" name="contentTitle" value="<?= e($content->title) ?>" readonly/>
        </label>
    </p>

    <p>
        <input class="button delete" type="submit" name="doDelete" value="Delete">
    </p>
    </fieldset>
</form>
