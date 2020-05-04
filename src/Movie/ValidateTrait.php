<?php

namespace Olj\Movie;

/**
 * A trait implementing validation of input for inserting into
 * and updating the database "movie".
 */
trait ValidateTrait
{
    private function validateImg()
    {
        $directory = explode("/", $this->img)[0];
        $hasDot = strpos($this->img, ".");
        $countFwSlash = substr_count($this->img, "/");

        if (ctype_alpha($directory) && $hasDot && $countFwSlash === 1) {
            return true;
        }
        return false;
    }
}
