<?php
/**
 * These routes are for demonstration purpose, to show how routes and
 * handlers can be created.
 */
return [
    // Path where to mount the routes, is added to each route path.
    "mount" => "movie",

    // All routes in order
    "routes" => [
        [
            "info" => "Controller for Movie Database.",
            "mount" => "",
            "handler" => "\Olj\Movie\MovieController",
        ],
    ]
];
