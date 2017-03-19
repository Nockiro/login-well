<?php
ini_set("display_errors", "E_ALL");
include_once 'core/functions.php';

sec_session_start();

$lastcard = -1;

if (isset($_GET["cp"])) {
    $currentpage = htmlspecialchars($_GET["cp"]);
} else {
    $currentpage = CONST_DefaultPage;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include ("content/header.php"); //add head of html ?>

    </head>
    <body>
        <?php include ("content/head.php"); //add head content of page ?>

        <?php include ("content/content.php"); //add page content ?>

    </body>
</html>