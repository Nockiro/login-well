<?php
include_once 'core/functions.php';
ini_set("display_errors", "E_ALL");

sec_session_start();

$lastcard = -1;

if (isset($_GET["cp"])) {
    $currentpage = htmlspecialchars($_GET["cp"]);
    $_SESSION["cp"] = $currentpage;
} else if (isset($_SESSION["cp"])) {
    $currentpage = htmlspecialchars($_SESSION["cp"]);
} else {
    $currentpage = CONST_DefaultPage;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Loginer: Welcome</title>
        <link rel="stylesheet" href="style.css" />

    </head>
    <body>

        <?php include ("content/content.php"); //add page content ?>

    </body>
</html>