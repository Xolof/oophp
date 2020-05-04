<form method="post">
    <fieldset>
    <legend>Add</legend>

    <p>
        <label>Title:<br> 
        <input type="text" name="movieTitle" value=""/>
        </label>
    </p>

    <p>
        <label>Year:<br> 
        <input type="number" name="movieYear" value="" min="1900" max="2100"/>
    </p>

    <p>
        <label>Image:<br> 
        <input type="text" name="movieImage" value=""/>
        </label>
    </p>

    <p>
        <input type="submit" name="add" value="Add" class="btn_movie btn_add_movie">
    </p>
    </fieldset>
</form>
