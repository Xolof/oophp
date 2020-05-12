<?php
namespace Olj\CMS;

class RequestHelper
{
    /**
     * Constructor to inititate the request object.
     * 
     * @param object $request A request object, for example "$this->app->request".
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Get values from POST and return as array.
     *
     * @param string $key   an array with values to get.
     *
     * @return array        an associative array with values from POST.
     */
    public function getPostArr($key)
    {
        if (is_array($key)) {
            foreach ($key as $val) {
                $post[$val] = $this->request->getPost($val);
            }
            return $post;
        }
    }
}