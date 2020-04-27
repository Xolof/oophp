<?php
/**
 * These routes are for demonstration purpose, to show how routes and
 * handlers can be created.
 */
return [
    // Path where to mount the routes, is added to each route path.
    "mount" => "dg2",

    // All routes in order
    "routes" => [
        [
            "info" => "Controller for Dice Game.",
            "mount" => "",
            "handler" => "\Olj\DiceGame\DiceGameController",
        ],
    ]
];
