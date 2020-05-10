<?php
/**
 * Route to demonstration of a class to filter text.
 */
return [
    // Path where to mount the routes, is added to each route path.
    "mount" => "filter",

    // All routes in order
    "routes" => [
        [
            "info" => "Controller for demonstartion of the class MyTextFilter.",
            "mount" => "",
            "handler" => "\Olj\Filter\FilterController",
        ],
    ]
];
