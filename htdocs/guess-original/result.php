<?php
require "src/config.php";
require "src/autoload.php";
require "src/session.php";
require "src/session_destroy.php";

if ($_SESSION["guessObj"]) {
    $guess = $_SESSION["guessObj"];
} else {
    header("Location: index.php");
    exit();
}

if ($_SESSION["result"] == "Correct") {
    $message = "<p>You guessed the number!</p><p> It's " . $guess->number() . ".</p>";
} else if ($guess->tries() < 1) {
    $message = "<p>You're out of guesses.</p>";
}

sessionDestroy();

include("view/header.php");
include("view/view_result.php");
include("view/footer.php");
