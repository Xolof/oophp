<?php
namespace Olj\Movie;

/**
 * Search for movies made between two years.
 */
class MovieSearchYear
{
    /**
     * Constructor to initiate the search with year 1 and year 2.
     *
     * @param int $year1 The first year.
     * @param int $year2 The second year
     */
    public function __construct($app, $year1 = null, $year2 = null)
    {
        $this->year1 = $year1;
        $this->year2 = $year2;
        $this->app = $app;
        // $this->result;
    }

    /**
     * Make a database query based on the years entered.
     *
     * @return object $res The result of the database query.
     */
    public function searchBetween()
    {
        $year1 = $this->year1;
        $year2 = $this->year2;

        $this->app->db->connect();
        if ($year1 && $year2) {
            $res = $this->searchTwoYears($year1, $year2);
        } else if ($year1 && !$year2) {
            $res = $this->searchYearOne($year1);
        } else if (!$year1 && $year2) {
            $res = $this->searchYearTwo($year2);
        } else {
            return false;
        }

        return $res;
    }

    /**
     * Make a db-query if two years entered
     *
     * @return object $res The result of the database query.
     */
    private function searchTwoYears($year1, $year2)
    {
        if (is_numeric($year1) && is_numeric($year2)) {
            $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
            $res = $this->app->db->executeFetchAll($sql, [$year1, $year2]);
            return $res;
        }
        return false;
    }

    /**
     * Make a db-query if year one entered
     *
     * @return object $res The result of the database query.
     */
    private function searchYearOne($year1)
    {
        if (is_numeric($year1)) {
            $sql = "SELECT * FROM movie WHERE year >= ?;";
            $res = $this->app->db->executeFetchAll($sql, [$year1]);
            return $res;
        }
        return false;
    }

    /**
     * Make a db-query if year two entered
     *
     * @return object $res The result of the database query.
     */
    private function searchYearTwo($year2)
    {
        if (is_numeric($year2)) {
            $sql = "SELECT * FROM movie WHERE year <= ?;";
            $res = $this->app->db->executeFetchAll($sql, [$year2]);
            return $res;
        }
        return false;
    }
}
