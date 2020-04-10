<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));


/**
 * Init and redirect to play the game.
 */
$app->router->get("guess/init", function () use ($app) {
    // Init the session to start the game.
    unset($_SESSION["result"]);

    $game = new Olj\Guess\Guess();
    $_SESSION["guessObj"] = $game;
    return $app->response->redirect("guess/play");
});


/**
 * Play the game.
 */
$app->router->get("guess/play", function () use ($app) {
    // Start the game.
    if (isset($_SESSION["error"])) {
        $error = $_SESSION["error"];
        unset($_SESSION["error"]);
    }
    
    if (!isset($_SESSION["guessObj"])) {
        $error = "The session expired or the game was not initiated.";
        $title = "Session expired";
        $data = [
            "error" => $error,
            "result" => null,
            "tries" => null,
            "secret_number" => null
        ];
    }

    if (isset($_SESSION["guessObj"])) {
        $guess = $_SESSION["guessObj"];
        
        if (isset($_SESSION["result"])) {
            if ($_SESSION["result"] == "Correct" || $guess->tries() < 1) {
                $app->response->redirect("guess/result");
            }

            $result = $_SESSION["result"];
        }

        if (isset($_GET["cheat"])) {
            $secret = $guess->number();
        }

        $title = "Guess the number";
        $data = [
            "error" => $error ?? null,
            "result" => $result ?? null,
            "tries" => $guess->tries() ?? null,
            "secret_number" => $secret ?? null
        ];
    }

    $app->page->add("/guess/play", $data);
    $app->page->add("/guess/form");
    // $app->page->add("/guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Play a round of the game.
 */
$app->router->post("guess/play", function () use ($app) {

    if (isset($_POST["number"])) {
        $_SESSION["numberGuessed"] = $_POST["number"];
        $app->response->redirect("guess/check");
    }
});

/**
 * Check the result of the round.
 */
$app->router->get("guess/check", function () use ($app) {
    
    $guess = $_SESSION["guessObj"];

    if (isset($_SESSION["numberGuessed"])) {
        try {
            $_SESSION["result"] = $guess->makeGuess($_SESSION["numberGuessed"]);
            $guess->decrementTries();
            unset($_SESSION["numberGuessed"]);
        } catch (Exception $e) {
            $_SESSION["error"] = $e->getMessage();
        }
    }
        $app->response->redirect("guess/play");
});

/**
 * View the result of the game.
 */
$app->router->get("guess/result", function () use ($app) {
    if ($_SESSION["guessObj"]) {
        $guess = $_SESSION["guessObj"];
    } else {
        $app->response->redirect("guess/play");
    }
    
    if ($_SESSION["result"] == "Correct") {
        $message = "<p>You guessed the number!</p><p>It's " . $guess->number() . ".</p>";
    } else if ($guess->tries() < 1) {
        $message = "<p>You're out of guesses.</p>";
    }

    unset($_SESSION["result"]);
    
    $title = "Result";
    $data = [
        "message" => $message ?? null,
    ];

    $app->page->add("/guess/view-result", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});
