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
        <?php include ("content/header.php"); //add head of html  ?>

    </head>
    <body>
        <?php include ("content/head.php"); //add head content of page  ?>

        <?php
        if (isset($_GET['msg'])) {
            $message = filter_input(INPUT_GET, 'msg');
            
            if ($message === "Success") {
                $lastcard = get_lastcard($mysqli);
            } else {
                if (startsWith($message, "I"))
                    $class = "info";
                else if (startsWith($message, "E"))
                    $class = "error";

                /* in addition to the content class, which generates standard output, add the info/error class for overwriting background color */
                echo '<div class="content ' . $class . ' ">' . get_msg(filter_input(INPUT_GET, 'msg')) . '</div>';
            }
        }
        ?>

        <?php include ("content/content.php"); //add page content ?>

    </body>
</html>