<?php
namespace Olj\CMS;

class Content
{
    /**
     * Constructor to inject the request object.
     * 
     * @param object $request A request object, for example "$this->app->request".
     */
    public function __construct($request, $db)
    {
        $this->request = $request;
        $this->db = $db;
    }

    /**
    * Create a slug of a string, to be used as url.
     *
     * @param string $str String to convert to slug.
     *
     * @return string $slug A slug, for example: "moomin-likes-mopeds"
     */
    public function slugify($str)
    {   
        $str = mb_strtolower(trim($str));
        $str = str_replace(array('å','ä','ö'), array('a','a','o'), $str);
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = trim(preg_replace('/-+/', '-', $str), '-');
        return $str;
    }

    /**
     * Save content.
     * 
     * @return void
     */
    public function save()
    {
        $helper = new RequestHelper($this->request);

        $params = $helper->getPostArr([
            "contentTitle",
            "contentPath",
            "contentSlug",
            "contentData",
            "contentType",
            "contentFilter",
            "contentPublish",
            "contentId"
        ]);

        $allowedFilters = ["nl2br", "bbcode", "link", "markdown"];

        foreach ($allowedFilters as $filter) {
            if ($this->request->getPost($filter)) {
                $params["contentFilter"] .= "," . $filter;
            }
        }

        $params["contentFilter"] = trim($params["contentFilter"], ",");

        if (!$params["contentPath"]) {
            $params["contentPath"] = null;
        }

        $id = $params["contentId"];

        if (!$params["contentSlug"]) {
            $slug = $this->slugify($params["contentTitle"]);

            $sql = "SELECT count(*) AS count FROM content WHERE slug = ? AND id != ?;";

            $this->db->connect();
            $res = $this->db->executeFetchAll($sql, [$slug, $id]);

            var_dump($res[0]->count);

            // Make the slug unique.
            if ($res[0]->count > 0) {
                $slug .= "-" . $id;
            }

            $params["contentSlug"] = $slug;
        }

        $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";

        $this->db->connect();

        $this->db->execute($sql, array_values($params));
    }
}
