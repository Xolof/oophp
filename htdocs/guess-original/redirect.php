<?php
require "src/config.php";
require "src/autoload.php";
require "src/session.php";

var_dump($_SESSION);

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

header("Location: index.php");
