<?php
namespace Olj\Movie;

/**
 * Add a movie to the database.
 */
class MovieAdd
{
    use ValidateTrait;

    /**
     * Constructor to initiate the object.
     *
     * @param string $movieTitle The title of the movie.
     * @param int $movieYear The year of the movie.
     * @param string $movieImage The name of the image file representing the movie.
     */
    public function __construct($app, $movieTitle, $movieYear, $movieImage)
    {
        $this->title = $movieTitle;
        $this->year = $movieYear;
        $this->app = $app;

        if ($movieImage === "") {
            $this->img = "img/noimage.png";
        } else {
            $this->img = $movieImage;
        }
    }

    public function insert()
    {
        if (!$this->validateImg()) {
            return false;
        }
        // Some kind of error handling.
        $this->app->db->connect();
        $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
        $this->app->db->execute($sql, [$this->title, $this->year, $this->img]);
        return true;
    }
}
