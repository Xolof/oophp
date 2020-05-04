<p>Do you really want to delete this movie?</p>
<form method="post" action="">
<input type="hidden" name="deleteId" value="<?= $movie->id ?>">
<input type="submit" name="confirmDelete" value="Yes, delete it!" class="btn_movie btn_delete_movie">
</form>
