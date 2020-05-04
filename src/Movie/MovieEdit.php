<?php
namespace Olj\Movie;

/**
 * Edit a movie in the database.
 */
class MovieEdit
{
    use ValidateTrait;

    /**
     * Constructor to initiate the object.
     *
     * @param string $movieTitle The title of the movie.
     * @param int $movieYear The year of the movie.
     * @param string $movieImage The name of the image file representing the movie.
     */
    public function __construct($app, $movieId, $movieTitle, $movieYear, $movieImage)
    {
        $this->id = $movieId;
        $this->title = $movieTitle;
        $this->year = $movieYear;
        $this->app = $app;

        if ($movieImage === "") {
            $this->img = "img/noimage.png";
        } else {
            $this->img = $movieImage;
        }
    }

    public function update()
    {
        if (!$this->validateImg()) {
            return false;
        }
        // Some kind of error handling.
        $this->app->db->connect();
        $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
        $this->app->db->execute($sql, [$this->title, $this->year, $this->img, $this->id]);
        return true;
    }
}
