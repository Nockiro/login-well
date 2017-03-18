<?php
include_once 'core/dbconnect.php';
include_once 'core/functions.php';
ini_set("display_errors", "E_ALL");

sec_session_start();

$lastcard = -1
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Loginer: Welcome</title>
        <link rel="stylesheet" href="style.css" />

    </head>
    <body>


        <?php
        if (isset($_GET['msg'])) {
            if (filter_input(INPUT_GET, 'msg') === "Success") {
                $lastcard = get_lastcard($mysqli);
            } else {
                echo '<p class="error">' . get_errormsg(filter_input(INPUT_GET, 'msg')) . '</p>';
            }
        }
        ?>
        <?php if (login_check($mysqli)) : ?>
            <h2 align="right">Loginer - Welcome</h2>
            <p>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</p>
            <p>Last Logout-Picture: <img src="account/getCard.php?img=<?php echo ($lastcard != -1 ? $lastcard : "nocard"); ?>" width="76" height="105"> </p>
            <p>Would you like to <a href="logout.php">logout</a>?</p>

        <?php else : ?>

            <?php if (isset($_GET['loggedout'])) { ?>

                <h2 align="right">Loginer - Logout</h2>
                Logout-Pic: <img src="account/getCard.php?img=<?php echo (isset($_COOKIE["img"]) ? $_COOKIE["img"] : "nocard"); ?>" width="76" height="105">

                <?php
                if (!isset($_COOKIE["img"])) {
                    echo "<p> Logout-Bild aus Sicherheitsgründen verfallen. </p>";
                }
                ?>

                <?php setcookie("img", "", time() - 3600);
            };
            ?>
            <p>
                <span class="error">You are not logged in.</span> Would you like to <a href="login.php">login</a>?.
            </p>
<?php endif; ?>
    </body>
</html>