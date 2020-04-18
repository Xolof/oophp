<?php
/**
 * Functions for the Dice Game.
 */

/**
 * Deciding who will begin based upon the state of the session.
 *
 * @param Game $game A Game object.
 *
 * @return string $message A message about the game.
*/
function decideBeginner($game, $message)
{
    if ($_SESSION["dg-state"]["current-player"] == null) {
        $message = "Kasta en tärning för att bestämma vem som börjar.";
    }
    
    if (isset($_SESSION["dg-state"]["set-first-player"])) {
        $firstThrows = $game->decideBeginner();

        $_SESSION["dg-state"]["decide-begin-throw"] = [
            $_SESSION["dg-state"]["human-name"] => $firstThrows[0],
            $_SESSION["dg-state"]["computer-name"] => $firstThrows[1]
        ];

        $firstPlayer = $game->getCurrentPlayerName();
        $_SESSION["dg-state"]["current-player"] = $firstPlayer;
        $playerName = $_SESSION["dg-state"][$firstPlayer . "-name"];
        $message = "<strong>" . $playerName . " börjar</strong>.";
        unset($_SESSION["dg-state"]["set-first-player"]);
    }
    
    if ($_SESSION["dg-state"]["current-player"] != null
        && $_SESSION["dg-state"]["active-throw"] != null) {
        $player = $_SESSION["dg-state"]["current-player"];
        $playerName = $_SESSION["dg-state"][$player . "-name"];

        $message .= "</p><p><strong>" . $playerName ."s tur</strong>.";
    }

    if ($_SESSION["dg-state"]["current-player"] != null) {
        if ($_SESSION["dg-state"]["active-throw"] == null) {
            $_SESSION["dg-state"]["active-throw"] = "begin";
        }
    }

    return $message;
}


/**
 * Change player.
 */
function changePlayer($event)
{
    // Change player
    if ($_SESSION["dg-state"]["current-player"] == "human") {
        $_SESSION["dg-state"]["current-player"] = "computer";
    } else {
        $_SESSION["dg-state"]["current-player"] = "human";
    };

    $_SESSION["dg-state"]["previous-acc"] = $_SESSION["dg-state"]["current-acc"];
    $_SESSION["dg-state"]["current-acc"] = [];

    $player = $_SESSION["dg-state"]["current-player"];

    $playerName = $_SESSION["dg-state"][$player . "-name"];

    $message = "<p></p>" . $event . ", <strong>nu är det " . $playerName . "s tur</strong>.";

    return $message;
}


/**
 * Simulate computer.
 */
function simulateComputer($game)
{
    for ($i = 0; $i < 3; $i++) {
        // Generate results
        $game->getCurrentPlayer()->makeRoll();
        $currentResult = $game->getCurrentPlayer()->getCurrentResult();

        $_SESSION["dg-state"]["current-acc"][] = $currentResult;

        $currentAcc = $_SESSION["dg-state"]["current-acc"];
        if ($currentAcc != []) {
            $game->getCurrentPlayer()->setAccArr($_SESSION["dg-state"]["current-acc"]);
        }

        $player = $_SESSION["dg-state"]["current-player"];
        $playerName = $_SESSION["dg-state"][$player . "-name"];

        if ($game->checkIfOne()) {
            $message = changePlayer("<p></p>" . $playerName . " slog en etta");
            return $message;
        }
    }

    $player = $_SESSION["dg-state"]["current-player"];

    // Spara resultat i session
    $_SESSION["dg-state"][$player . "-total"] += $game->getCurrentPlayer()->getAccInt();

    // Check if win
    if (checkWin($player)) {
        return "win";
    };

    $player = $_SESSION["dg-state"]["current-player"];
    $playerName = $_SESSION["dg-state"][$player . "-name"];

    // Ändra spelare
    $message = changePlayer("<p></p>" . $playerName . " sparade resultatet");

    $_SESSION["dg-state"]["save"] = false;

    return $message;
}

/**
 * Check if someone has won.
 */
function checkWin($currentPlayer)
{
    if ($_SESSION["dg-state"][$currentPlayer . "-total"] >= 100) {
        $player = $_SESSION["dg-state"]["current-player"];
        $playerName = $_SESSION["dg-state"][$player . "-name"];
        $_SESSION["dg-state"]["winner"] = $playerName;
        return true;
    }
}
