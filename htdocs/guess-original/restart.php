<?php
require "src/config.php";
require "src/autoload.php";
require "src/session.php";
require "src/session_destroy.php";

sessionDestroy();

header("Location: index.php");
