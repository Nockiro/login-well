<?php
ini_set("display_errors", "E_ALL");
include_once 'core/functions.php';

check_for_dbupdate($mysqli);
sec_session_start();

if (isset($_GET["cp"]) && !empty($_GET["cp"])) {
    $currentpage = htmlspecialchars($_GET["cp"]);
} else {
    $currentpage = CONST_DefaultPage;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include ("content/htmlhead.php"); //add head of html  ?>

    </head>
    <body>
        <?php include ("content/head.php"); //add head content of page  ?>


        <!-- in case we need to do something with _all_ content, we put it in a div with id main 
            For example, we need to get the content 250px to the left for the sidebar -->
        <div id="main">
            <?php
            if (isset($_GET['msg'])) {

                // checking for more than one message
                $query = explode('&', $_SERVER['QUERY_STRING']);
                $messages = array();

                // get all msg params manually
                foreach ($query as $param) {
                    list($name, $value) = explode('=', $param, 2);
                    if (urldecode($name) == "msg")
                        array_push($messages, urldecode($value));
                }

                foreach ($messages as $message) {

                    $message = htmlspecialchars($message);
                    
                    if ($message !== "Success") {
                        /* in addition to the content class, which generates standard output, add the info/error class for overwriting background color */
                        if (startsWith($message, "I"))
                            $class = "info";
                        else if (startsWith($message, "E"))
                            $class = "error";

                        $message = language::get_msg($message);
                        /* if there is actually a message with this error/information code, show it - otherwise, don't */
                        if (!empty($message))
                            echo '<div class="content ' . $class . ' ">' . $message . '</div>';
                    }
                }
            }
            ?>
            <?php include ("content/content.php"); //add page content ?>
        </div>
    </body>
</html>