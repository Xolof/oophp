<?php

namespace Olj\Movie;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;


/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class MovieController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";

    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = "active";

        // Use $this->app to access the framework services.
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : string
    {
        // Deal with the action and return a response.
        // return __METHOD__ . ", \$db is {$this->db}";

        return "Index";
    }

    /**
     * Debug method action
     *
     * @return string
     */
    public function debugAction() : string
    {
        // Deal with the action and return a response.
        // return __METHOD__ . ", \$db is {$this->db}";

        return "Debug";
    }

    /**
     * Show all method action
     *
     * @return object
     */
    public function showAction() : object
    {
        $title = "Show all | Movie database";

        $this->app->db->connect();
        $sql = "SELECT * FROM movie;";
        $res = $this->app->db->executeFetchAll($sql);

        $warning = null;

        $this->app->page->add("movie/header", [
            "warning" => $warning ?? null
        ]);

        $this->app->page->add("movie/show-all", [
            "resultset" => $res,
        ]);
        $this->app->page->add("movie/footer");
    
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * Search title method action
     *
     * @return object
     */
    public function searchtitleAction() : object
    {
        $request = $this->app->request;

        $title = "Search title | Movie database";

        $searchTitle = htmlentities($request->getGet("searchTitle"));

        if ($searchTitle) {
            $this->app->db->connect();
            $sql = "SELECT * FROM movie WHERE title LIKE ?;";
            $res = $this->app->db->executeFetchAll($sql, [$searchTitle]);
        }

        $warning = null;

        $this->app->page->add("movie/header", [
            "warning" => $warning ?? null,
        ]);

        $this->app->page->add("movie/search-title", [
            "searchTitle" => $searchTitle ?? null
        ]);

        $this->app->page->add("movie/show-all", [
            "resultset" => $res ?? null,
        ]);
        $this->app->page->add("movie/footer");
    
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * Search year method action
     *
     * @return object
     */
    public function searchyearAction()
    {
        $request = $this->app->request;

        $title = "Search year | Movie database | oophp";

        $year1 = $request->getGet("year1");
        $year2 = $request->getGet("year2");

        if ($year1 or $year2) {
            try {
                $search = new MovieSearchYear($this->app, $year1, $year2);

                $res = $search->searchBetween();
        
                if (!$res) {
                    throw new SearchException();
                }
            } catch (SearchException $e) {
                return "Invalid input!";
            }
        }

        $warning = null;

        $this->app->page->add("movie/header", [
            "warning" => $warning ?? null,
        ]);

        $this->app->page->add("movie/search-year", [
            "year1" => $year1 ?? null,
            "year2" => $year2 ?? null
        ]);

        $this->app->page->add("movie/show-all", [
            "resultset" => $res ?? null,
        ]);
        $this->app->page->add("movie/footer");
    
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * Edit method action
     *
     * @return object
     */
    public function editAction() : object
    {
        $request = $this->app->request;

        $title = "Edit | Movie database";

        $add = $request->getPost("doAdd");
        $edit = $request->getPost("doEdit");
        $delete = $request->getPost("doDelete");
        $movieId = $request->getPost("movieId");

        if ($add) {
            return $this->app->response->redirect("movie/addmovie");
        }

        if ($edit && $movieId) {
            $this->app->session->set("movieId", $movieId);
            return $this->app->response->redirect("movie/editmovie");
        }

        if ($delete && $movieId) {
            $this->app->session->set("movieId", $movieId);
            return $this->app->response->redirect("movie/deletemovie");
        }


        $this->app->db->connect();
        $sql = "SELECT * FROM movie;";
        $res = $this->app->db->executeFetchAll($sql);

        $warning = null;

        $this->app->page->add("movie/header", [
            "warning" => $warning ?? null,
        ]);

        $this->app->page->add("movie/movie-select", [
            "movies" => $res ?? null,
        ]);
        $this->app->page->add("movie/footer");
    
        return $this->app->page->render([
            "title" => $title,
        ]);
    }


    
    /**
     * Add method action
     *
     * @return object
     */
    public function addmovieAction() : object
    {
        $request = $this->app->request;

        $add = $request->getPost("add");
        $movieTitle = $request->getPost("movieTitle");
        $movieYear = $request->getPost("movieYear");
        $movieImage = $request->getPost("movieImage");

        if ($add && $movieTitle && $movieYear) {
            // Make an object responsible for solving the action
            $addObj = new MovieAdd($this->app, $movieTitle, $movieYear, $movieImage);
            $res = $addObj->insert();
            if ($res === true) {
                return $this->app->response->redirect("movie/show");
            } else {
                $warning = "Movie not added, check your input.";
            }
        }

        $title = "Add | Movie database";

        $this->app->page->add("movie/header", [
            "warning" => $warning ?? null
        ]);
        $this->app->page->add("movie/add");
        $this->app->page->add("movie/footer");
    
        return $this->app->page->render([
            "title" => $title
        ]);
    }

    /**
     * Edit method action
     *
     * @return object
     */
    public function editmovieAction() : object
    {

        $movieIdSession = $this->app->session->get("movieId");

        // Get data about movie to edit
        $this->app->db->connect();
        $sql = "SELECT * FROM movie WHERE id = ?;";
        $res = $this->app->db->executeFetchAll($sql, [$movieIdSession]);
        $movie = $res[0];

        $request = $this->app->request;
        $save = $request->getPost("doSave");
        $movieId = $request->getPost("movieId");
        $movieTitle = $request->getPost("movieTitle");
        $movieYear = $request->getPost("movieYear");
        $movieImage = $request->getPost("movieImage");

        if ($save && $movieId && $movieTitle && $movieYear) {
            // Make an object responsible for solving the action
            $editObj = new MovieEdit($this->app, $movieId, $movieTitle, $movieYear, $movieImage);
            $res = $editObj->update();
            if ($res === true) {
                $this->app->session->delete("movieId");
                return $this->app->response->redirect("movie/show");
            } else {
                $warning = "Movie not updated, check your input.";
            }
        }

        $title = "Edit | Movie database";

        $this->app->page->add("movie/header", [
                "warning" => $warning ?? null,
        ]);
        $this->app->page->add("movie/edit", [
            "movie" => $movie ?? null
        ]);
        $this->app->page->add("movie/footer");
    
        return $this->app->page->render([
            "title" => $title
        ]);
    }

    /**
     * Delete method action
     *
     * @return object
     */
    public function deletemovieAction() : object
    {
        $request = $this->app->request;

        $confirmDelete = $request->getPost("confirmDelete");
        $deleteId = $request->getPost("deleteId");

        // If delete action has been confirmed.
        if ($confirmDelete) {
            // var_dump([$confirmDelete, $deleteId]);
            $this->app->db->connect();
            $sql = "DELETE FROM movie WHERE id = ?;";
            $this->app->db->execute($sql, [$deleteId]);


            $this->app->session->set("message", "Movie with id " . $deleteId . " deleted.");
            return $this->app->response->redirect("movie/edit");
        }

        // Get data about movie to delete.
        $movieId = $this->app->session->getOnce("movieId");

        if (!$movieId && !$confirmDelete) {
            return $this->app->response->redirect("movie/edit");
        }

        $this->app->db->connect();
        $sql = "SELECT * FROM movie WHERE id = ?;";
        $res = $this->app->db->executeFetchAll($sql, [$movieId]);
        $movie = $res[0];

        $title = "Confirm delete | Movie database";

        $warning = null;

        $this->app->page->add("movie/header", [
            "warning" => $warning ?? null,
        ]);
        $this->app->page->add("movie/show-one", [
            "movie" => $movie ?? null
        ]);
        $this->app->page->add("movie/confirm-delete", [
            "movie" => $movie ?? null
        ]);
        $this->app->page->add("movie/footer");
    
        return $this->app->page->render([
            "title" => $title
        ]);
    }

    /**
     * Reset method action
     * Reset the database.
     *
     * @return object
     */
    public function resetAction() : object
    {
        $request = $this->app->request;

        $reset = $request->getPost("reset");

        if ($reset) {
            $resetObj = new ResetMovie();

            $sql = $resetObj->getSql();

            $this->app->db->connect();
            foreach ($sql as $query) {
                $this->app->db->execute($query);
            }

            return $this->app->response->redirect("movie/show");
        }

        $title = "Reset | Movie database";

        $warning = null;
        $movie = null;

        $this->app->page->add("movie/header", [
                "warning" => $warning ?? null,
        ]);
        $this->app->page->add("movie/reset", [
            "movie" => $movie ?? null
        ]);
        $this->app->page->add("movie/footer");
    
        return $this->app->page->render([
            "title" => $title
        ]);
    }
}
