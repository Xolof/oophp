<?php

namespace Olj\CMS;

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
class CMSController implements AppInjectableInterface
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
        return "index";
    }


    /**
     * Action method for route "landing".
     *
     * @return object
     */
    public function landingAction() : object
    {

        $title = "Landing";

        $this->app->db->connect();

        $sql = <<<EOD
        SELECT * FROM content
        WHERE deleted IS NULL OR deleted > NOW()
        ORDER BY published DESC;
EOD;

        $res = $this->app->db->executeFetchAll($sql);

        $this->app->page->add("cms/header");
        $this->app->page->add("cms/landing", ["res" => $res]);
        $this->app->page->add("cms/footer");
        return $this->app->page->render([
            "title" => $title,
        ]);
    }


    /**
     * Action method for route "show".
     *
     * @return object
     */
    public function showAction() : object
    {
        
        $title = "Show all content";

        $this->app->db->connect();

        $sql = "SELECT * FROM content ORDER BY id DESC;";

        $res = $this->app->db->executeFetchAll($sql);

        $this->app->page->add("cms/header");
        $this->app->page->add("cms/index", ["res" => $res]);
        $this->app->page->add("cms/footer");
        return $this->app->page->render([
            "title" => $title,
        ]);
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
     * Method action for route "admin"
     *
     * @return object
     */
    public function adminAction() : object
    {
        $title = "Admin panel";

        $this->app->db->connect();

        $sql = "SELECT * FROM content ORDER BY id DESC;";

        $res = $this->app->db->executeFetchAll($sql);

        $this->app->page->add("cms/header");
        $this->app->page->add("cms/admin", ["res" => $res]);
        $this->app->page->add("cms/footer");
        return $this->app->page->render([
            "title" => $title,
        ]);
    }


    /**
     * Method action for route "create"
     *
     * @return object
     */
    public function createAction() : object
    {
        $title = "Create content";

        $this->app->page->add("cms/header");
        $this->app->page->add("cms/create");
        $this->app->page->add("cms/footer");
        return $this->app->page->render([
            "title" => $title,
        ]);
    }



    /**
     * Method action for route "docreate"
     *
     * @return object
     */
    public function docreateAction() : object
    {
        $request = $this->app->request;

        if ($request->getPost("doCreate")) {
            $title = $request->getPost("contentTitle");

            $sql = "INSERT INTO content (title) VALUES (?);";
            
            $this->app->db->connect();
            $this->app->db->execute($sql, [$title]);

            $id = $this->app->db->lastInsertId();
            return $this->app->response->redirect("cms/edit?id=" . $id);
        } 
    }
   

    /**
     * Method action for route "edit"
     *
     * @return object
     */
    public function editAction() : object
    {
        $request = $this->app->request;

        $title = "Edit content";

        $contentId = $request->getPost("contentId") ?: $request->getGet("id");
        
        if (!is_numeric($contentId)) {
            return $this->app->page->render("invalid");
        }

        $sql = "SELECT * FROM content WHERE id = ?;";

        $this->app->db->connect();

        $content = $this->app->db->executeFetch($sql, [$contentId]);

        $this->app->page->add("cms/header");
        $this->app->page->add("cms/edit", [
            "content" => $content
        ]);
        $this->app->page->add("cms/footer");
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * Method action for route "save"
     *
     * @return object
     */
    public function saveAction() : object
    {
        $request = $this->app->request;
        $content = new Content($request, $this->app->db);

        if ($request->getPost("doSave")) {
            $content->save();

            $id = $request->getPost("contentId");

            return $this->app->response->redirect("cms/edit?id=" . $id);
        }    
    }


    /**
     * Method action for route "delete"
     *
     * @return object
     */
    public function deleteAction() : object
    {
        $request = $this->app->request;

        $title = "Delete content";

        $contentId = $request->getPost("contentId") ?: $request->getGet("id");
        
        if (!is_numeric($contentId)) {
            return $this->app->page->render("invalid");
        }

        $sql = "SELECT id, title FROM content WHERE id = ?;";

        $this->app->db->connect();

        $content = $this->app->db->executeFetch($sql, [$contentId]);

        $this->app->page->add("cms/header");
        $this->app->page->add("cms/delete", [
            "content" => $content
        ]);
        $this->app->page->add("cms/footer");
        return $this->app->page->render([
            "title" => $title,
        ]);
    }


    /**
     * Method action for route "dodelete"
     *
     * @return object
     */
    public function dodeleteAction() : object
    {
        $request = $this->app->request;
        if ($request->getPost("doDelete")) {
            $contentId = $request->getPost("contentId");
            $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
            $this->app->db->connect();
            $this->app->db->execute($sql, [$contentId]);
        }

        return $this->app->response->redirect("cms/admin");
    }


    /**
     * Method action for route "pages"
     *
     * @return object
     */
    public function pagesAction() : object
    {
        $title = "View pages";

        $sql = <<<EOD
            SELECT
                *,
                CASE 
                    WHEN (deleted <= NOW()) THEN "isDeleted"
                    WHEN (published <= NOW()) THEN "isPublished"
                    ELSE "notPublished"
                END AS status
            FROM content
            WHERE type=?
            ;
EOD;

        $this->app->db->connect();

        $res = $this->app->db->executeFetchAll($sql, ["page"]);

        $filter = new \Olj\Filter\MyTextFilter();
        
        foreach ($res as $page) {
            $page->data = $filter->parse($page->data, $page->filter);
        }
        
        $this->app->page->add("cms/header");
        $this->app->page->add("cms/pages", ["res" => $res]);
        $this->app->page->add("cms/footer");
        return $this->app->page->render([
            "title" => $title,
        ]);
    }


    /**
     * Method action for route "blog"
     *
     * @return object
     */
    public function blogAction() : object
    {
        $title = "View blog";

        $sql = <<<EOD
            SELECT
                *,
                DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
                DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published,
                DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d-%H-%i-%s') AS published_time
                FROM content
            WHERE type=?
            ORDER BY published_time DESC
            ;
EOD;

        $this->app->db->connect();

        $res = $this->app->db->executeFetchAll($sql, ["post"]);

        $filter = new \Olj\Filter\MyTextFilter();
    
        foreach ($res as $page) {
            $page->data = $filter->parse($page->data, $page->filter);
        }

        $this->app->page->add("cms/header");
        $this->app->page->add("cms/blog", ["res" => $res]);
        $this->app->page->add("cms/footer");
        return $this->app->page->render([
            "title" => $title,
        ]);
    }


    /**
     * Action get method for the route "blogpost".
     * GET mountpoint/blogpost/<value>
     *
     * @param mixed $slug
     *
     * @return object
     */
    public function blogpostActionGet($slug) : object
    {
        $sql = <<<EOD
            SELECT
                *,
                DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
                DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
            FROM content
            WHERE 
                slug = ?
                AND type = ?
                AND (deleted IS NULL OR deleted > NOW())
                AND published <= NOW()
            ORDER BY published DESC
            ;
EOD;

            $this->app->db->connect();

            $content = $this->app->db->executeFetch($sql, [$slug, "post"]);

            $filter = new \Olj\Filter\MyTextFilter();

            $content->data = $filter->parse($content->data, $content->filter);

            $title = $content->title;
            
            $this->app->page->add("cms/header");
            $this->app->page->add("cms/blogpost", ["content" => $content]);
            $this->app->page->add("cms/footer");
            return $this->app->page->render([
                "title" => $title,
            ]);
    }


    /**
     * Action get method for the route "page".
     * GET mountpoint/page/<value>
     *
     * @param mixed $id
     *
     * @return object
     */
    public function pageActionGet($path) : object
    {
        $sql = <<<EOD
        SELECT
            *,
            DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
            DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
        FROM content
        WHERE
            path = ?
            AND type = ?
            AND (deleted IS NULL OR deleted > NOW())
            AND published <= NOW()
        ;
EOD;

        $this->app->db->connect();

        $content = $this->app->db->executeFetch($sql, [$path, "page"]);
        
        $this->app->page->add("cms/header");

        if (!$content) {
            $this->app->page->add("cms/404");
            $this->app->page->add("cms/footer");
            return $this->app->page->render();
        }

        $filter = new \Olj\Filter\MyTextFilter();

        $content->data = $filter->parse($content->data, $content->filter);

        $title = $content->title;
        
        $this->app->page->add("cms/page", ["content" => $content]);
        $this->app->page->add("cms/footer");
        return $this->app->page->render([
            "title" => $title,
        ]);
    }


    /**
     * Method action for route "pages"
     *
     * @return object
     */
    public function resetAction() : object
    {
        $request = $this->app->request;

        if ($request->getPost("reset")) {
            //  Config for student server.
            if ($_SERVER["SERVER_NAME"] === "www.student.bth.se") {
                $allSql = file_get_contents(explode("redovisa", __DIR__)[0] . "redovisa/sql/content/setup.sql");
            } else {
                $allSql = file_get_contents(explode("redovisa", __DIR__)[0] . "redovisa\\sql\\content\\setup.sql");
            }

            $allSql = substr($allSql, 0, strlen($allSql) -2);

            $arraySql = explode(";", trim($allSql, ";"));

            $this->app->db->connect();

            foreach ($arraySql as $query) {
                $query .= ";";
                $this->app->db->execute($query);
            }
            return $this->app->response->redirect("cms/show");
        }

        $title = "Reset tables";

        $this->app->page->add("cms/header");
        $this->app->page->add("cms/reset");
        $this->app->page->add("cms/footer");
        return $this->app->page->render([
            "title" => $title,
        ]);
    }
}
