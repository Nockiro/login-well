<?php
include_once 'core/functions.php';
ini_set("display_errors", "0");
sec_session_start();

$usercount = get_usercount($mysqli);
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
            <p><?php echo htmlentities($_SESSION['username']); ?>, you are already logged in.!</p>
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
            <p>If you don't have a login, please <a href="register.php">register</a>.</p>
            <p>There <?php echo ($usercount > 1 ? "are" : "is") ?> currently <?php echo $usercount . ($usercount > 1 ? " Users" : " User"); ?> registered.</p>	
        <?php endif; ?>
    </body>
</html>