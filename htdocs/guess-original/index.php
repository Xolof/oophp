<?php
require "src/config.php";
require "src/autoload.php";
require "src/session.php";
require "src/session_destroy.php";

include("view/header.php");
include("view/form.php");
?>

<?php

if (isset($_SESSION["error"])) {
    echo "<p>" . $_SESSION["error"] . "</p>";
    unset($_SESSION["error"]);
}


if (!isset($_SESSION["guessObj"])) {
    $_SESSION["guessObj"] = new Guess();
}

$guess = $_SESSION["guessObj"];


if (isset($_POST["number"])) {
    $_SESSION["numberGuessed"] = $_POST["number"];
    header("Location: redirect.php");
}

if (isset($_SESSION["result"])) {
    echo "<p>" .$_SESSION["result"] . "</p>";

    if ($_SESSION["result"] == "Correct" || $guess->tries() < 1) {
        header("Location: result.php");
        exit();
    }

    unset($_SESSION["result"]);
}

echo "<p>Tries left: " . $guess->tries() . "</p>";

if (isset($_GET["cheat"])) {
    echo "<p>Secret number: " . $guess->number() . "</p>"; 
}

?>

<?php
include("view/footer.php");
