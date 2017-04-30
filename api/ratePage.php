<?php

include_once '../core/functions.php';
sec_session_start();

$pid = htmlspecialchars($_POST["pid"]);
$rating = htmlspecialchars($_POST["rating"]);

// TODO: Die Werte in die Datenbank bekommen
// UserID abfragbar mittels $_SESSION["user_id"];
?>