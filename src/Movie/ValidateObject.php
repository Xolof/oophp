<?php
namespace Olj\Movie;

/**
 * This object is only intended for testing the validate trait.
 */
class ValidateObject
{
    use ValidateTrait;
    
    /**
     * Constructor to initiate the object.
     *
     * @param string $movieImage The name of an image file representing a movie.
     */
    public function __construct($movieImage)
    {
        $this->img = $movieImage;
    }

    public function validate()
    {
        return $this->validateImg($this->img);
    }
}
