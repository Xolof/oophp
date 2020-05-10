<?php
/**
 * Route to demonstration of a class to filter text.
 */
return [
    // Path where to mount the routes, is added to each route path.
    "mount" => "cms",

    // All routes in order
    "routes" => [
        [
            "info" => "Controller for my content management system.",
            "mount" => "",
            "handler" => "\Olj\CMS\CMSController",
        ],
    ]
];
