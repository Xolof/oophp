<?php
namespace Anax\View;

?>

<form action="save" method="post">

<input type="hidden" name="contentId" value="<?= e($content->id)?>">

<p>
    <label>Title:<br> 
    <input type="text" name="contentTitle" value="<?= e($content->title) ?>"/>
</p>

<p>
    <label>Type:<br>
    <label for="page">Page</label>
    <input type="radio" name="contentType" value="page" id="page" <?= $content->type === "page" ? "checked" : null ?>>
    <br>
    <label for="post">Post</label>
    <input type="radio" name="contentType" value="post" id="post" <?= $content->type === "post" ? "checked" : null ?>>
</p>

<p>
    <label>Slug:<br> 
    <input type="text" name="contentSlug" value="<?= e($content->slug) ?>"/>
</p>

<p>
    <label>Path:<br> 
    <input type="text" name="contentPath" value="<?= e($content->path) ?>"/>
</p>

<p>
    <label>Text:<br> 
    <textarea name="contentData"><?= e($content->data) ?></textarea>
 </p>

    <h6>Filters:</h6>

    <p>The filters "link" and "nl2br" are not compatible with the filter "markdown".
        If "link" or "nl2br" are selected with "markdown", "markdown" will override them.
    </p>

    <?php
        // Get the allowed filters and make a checkbox for each of them.
        // If a filter is applied, make the checkbox checked.
        $filterObj = new \Olj\Filter\MyTextFilter();
        $allowedFilters = array_keys($filterObj->getFilters());
        $appliedFilters = explode(",", $content->filter);
    ?>

    <?php foreach ($allowedFilters as $fil) : ?>
        <label for="<?= $fil ?>"><?= $fil ?></label>
        <input type="checkbox" name="<?= $fil ?>" id="<?= $fil ?>" value="<?= $fil ?>" <?= in_array($fil, $appliedFilters) ? "checked" : null ?>><br>
    <?php endforeach; ?>

 <p>
     <label>Publish:<br> 
     <input type="datetime" name="contentPublish" value="<?= e($content->published) ?>"/>
 </p>

 <p>
    <input type="submit" name="doSave" id="doSave" value="Save">
    <input type="reset" name="reset" id="reset" value="Reset">
    <input class="button delete" type="submit" name="delete" id="delete" value="Delete">
 </p>

</form>
