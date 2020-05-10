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
     * @return object
     */
    public function indexAction() : object
    {
        
        $title = "Show all content";

        $this->app->db->connect();

        $sql = "SELECT * FROM content;";

        $res = $this->app->db->executeFetchAll($sql);

        $this->app->page->add("cms/header");

        $this->app->page->add("cms/index", ["res" => $res]);

        // $this->app->page->add("cms/footer");

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
     * MEthod action for route "admin"
     *
     * @return string
     */
    public function adminAction() : string
    {
        
        return "Admin panel coming soon";
    }
}
