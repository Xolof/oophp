<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));

require("../src/DiceGameFunctions/functions.php");

/**
 * Init and redirect to play the game.
 */
$app->router->post("dice/init", function () use ($app) {

    /**
     * Init session variables.
     */
    $_SESSION["dg-state"] = [
        "current-player" => null,
        "current-result" => null,
        "current-acc" => [],
        "human-total" => null,
        "computer-total" => null,
        "human-name" => null,
        "computer-name" => "Datorn",
        "save" => null,
        "set-first-player" => null,
        "active-throw" => null,
        "winner" => null
    ];

    if (isset($_POST["player-name"])) {
        $_SESSION["dg-state"]["human-name"] = $_POST["player-name"];
    }

    return $app->response->redirect("dice/play");
});

$app->router->get("dice/play", function () use ($app) {

    // Create a new Game object.
    $game = new Olj\DiceGame\Game();

    // Inject some data from the session into the Game object.

    // Current player
    $currentPlayer = $_SESSION["dg-state"]["current-player"];
    if ($currentPlayer != null) {
        $game->setCurrentPlayer(new Olj\DiceGame\Player($currentPlayer));
    }

    // The total result for the current player.
    $currentTotal = $_SESSION["dg-state"][$currentPlayer . "-total"] ?? null;
    if ($currentTotal != null) {
        $game->getCurrentPlayer()->setTotal($currentTotal);
    }

    // The accumulated result which might be saved if the player chooses to do so.
    $currentAcc = $_SESSION["dg-state"]["current-acc"];
    if ($currentAcc != []) {
        $game->getCurrentPlayer()->setAccArr($_SESSION["dg-state"]["current-acc"]);
    }

    $message = "";

    // Deciding who will begin.
    $message = decideBeginner($game, $message);

    // If "save" is set.
    if ($_SESSION["dg-state"]["save"] == true) {
        // Spara resultat i session
        $_SESSION["dg-state"][$currentPlayer . "-total"] += $game->getCurrentPlayer()->getAccInt();

        // Check if win.
        if (checkWin($currentPlayer)) {
            $app->response->redirect("dice/result");
        };

        // Change player.
        $player = $_SESSION["dg-state"]["current-player"];
        $playerName = $_SESSION["dg-state"][$player . "-name"];
        $message = changePlayer("<p></p>" . $playerName . " sparade resultatet", $game);

        // Set "save" to false.
        $_SESSION["dg-state"]["save"] = false;
    } else if ($_SESSION["dg-state"]["current-player"]
        && !isset($_SESSION["dg-state"]["set-first-player"])
        && $_SESSION["dg-state"]["active-throw"] == "active") {
        // Beginning the real throws.
    if ($_SESSION["dg-state"]["current-player"] == "human") {
        // Generate results.
        $game->getCurrentPlayer()->makeRoll();
        $currentResult = $game->getCurrentPlayer()->getCurrentResult();

        // Assign current result to session.
        $_SESSION["dg-state"]["current-acc"][] = $currentResult;

        // Get the last player.
        $player = $_SESSION["dg-state"]["current-player"];
        $playerName = $_SESSION["dg-state"][$player . "-name"];

        // Check if there's a die with value one in the last throw.
        if ($game->checkIfOne()) {
            // If so, change player and create a message.
            $message = changePlayer($playerName . " slog en etta");
        }
    } else if ($_SESSION["dg-state"]["current-player"] == "computer") {
        // Simulate the computers throws.
        $message = simulateComputer($game);
        if ($message == "win") {
            $app->response->redirect("dice/result");
        }
    }
    }

    $title = "Tärningsspelet";

    $data = [
        "message" => $message ?? null,
        "currentResult" => $currentResult ?? null,
        "humanName" => $_SESSION["dg-state"]["human-name"],
        "computerName" => $_SESSION["dg-state"]["computer-name"],
        "humanPoints" => $_SESSION["dg-state"]["human-total"],
        "computerPoints" => $_SESSION["dg-state"]["computer-total"],
        "currentAcc" => $_SESSION["dg-state"]["current-acc"],
        "previousAcc" => $_SESSION["dg-state"]["previous-acc"] ?? null,
        "currentPlayer" => $_SESSION["dg-state"]["current-player"] ?? null
    ];

    $app->page->add("/dice/play", $data);
    $app->page->add("/dice/form");
    $app->page->add("/dice/info", $data);
    $app->page->add("/dice/reset");
    // $app->page->add("/dice/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Redirection route.
 */
$app->router->get("dice/check", function () use ($app) {

    if ($_SESSION["dg-state"]["current-player"] == null) {
        $_SESSION["dg-state"]["set-first-player"] = true;
    }

    if ($_SESSION["dg-state"]["active-throw"] == "begin") {
        $_SESSION["dg-state"]["active-throw"] = "active";
    }

    $app->response->redirect("dice/play");
});

/**
 * Play a round of the game.
 */
$app->router->post("dice/play", function () use ($app) {
    if (isset($_POST["save"])) {
        $_SESSION["dg-state"]["save"] = true;
    };

    $app->response->redirect("dice/check");
});


/**
 * Show the final result of the game.
 */
$app->router->get("dice/result", function () use ($app) {
    $title = "Tärningsspelet";

    $winner = $_SESSION["dg-state"]["winner"];

    $data = [
        "message" => "Nu är spelet slut och " . $winner . " har vunnit!",
        "humanPoints" => $_SESSION["dg-state"]["human-total"],
        "computerPoints" => $_SESSION["dg-state"]["computer-total"],
        "humanName" => $_SESSION["dg-state"]["human-name"],
        "computerName" => $_SESSION["dg-state"]["computer-name"]
    ];

    $app->page->add("/dice/result", $data);
    $app->page->add("/dice/reset");

    return $app->page->render([
        "title" => $title,
    ]);
});
