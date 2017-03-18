<?php
sec_session_start();

$usercount = get_usercount($mysqli);

if (isset($_GET['msg'])) {
    if (filter_input(INPUT_GET, 'msg') === "Success") {
        $lastcard = get_lastcard($mysqli);
    } else {
        echo '<p class="error">' . get_errormsg(filter_input(INPUT_GET, 'msg')) . '</p>';
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Loginer: Log In</title>
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script> 
        <link rel="stylesheet" href="style.css" />
    </head>
    <body>
        <?php if (login_check($mysqli)) : ?>
            <h2 align="right">Loginer - Welcome</h2>
            <p>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</p>
            <p>Last Logout-Picture: <img src="account/getCard.php?img=<?php echo ($lastcard != -1 ? $lastcard : "nocard"); ?>" width="76" height="105"> </p>
            <p>Would you like to <a href="logout.php">logout</a>?</p>
        <?php else : ?>
            <h2 align="right">Loginer - Log In</h2>
            <div style="width:600px">

                <form method="post" action="account/process_login.php" name = "login_form">

                    <ul>

                        <li>
                            <label for="pass_id">E-Mail</label>
                            <input type="text" name="email" id="email" value="" />
                        </li>

                        <li>
                            <label for="pass_id">Password</label>
                            <input type="password" name="password" id="password" value="" />
                        </li>

                        <li>
                            <input type="button" onclick="formhash(this.form, this.form.password);" value="Login" />
                        </li>

                    </ul>

                </form>

            </div>
            <p>If you don't have a login, please <a href=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?cp=register">register</a>.</p>
            <p>There <?php echo ($usercount > 1 ? "are" : "is") ?> currently <?php echo $usercount . ($usercount > 1 ? " Users" : " User"); ?> registered.</p>	
        <?php endif; ?>
    </body>
</html>