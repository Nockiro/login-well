<?php
include_once 'core/register.inc.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Loginer: Registration Form</title>
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script>
        <link rel="stylesheet" href="style.css" />
    </head>
    <body>
        <!-- Anmeldeformular für die Ausgabe, wenn die POST-Variablen nicht gesetzt sind
        oder wenn das Anmelde-Skript einen Fehler verursacht hat. -->
        <h2 align="right">Loginer - Register</h2>
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
        <ul>
            <li>Benutzernamen dürfen nur Ziffern, Groß- und Kleinbuchstaben und Unterstriche enthalten.</li>
            <li>E-Mail-Adressen müssen ein gültiges Format haben.</li>
            <li>Passwörter müssen mindest sechs Zeichen lang sein.</li>
            <li>Passwörter müssen enthalten
                <ul>
                    <li>mindestens einen Großbuchstaben (A..Z)</li>
                    <li>mindestens einen Kleinbuchstabenr (a..z)</li>
                    <li>mindestens eine Ziffer (0..9)</li>
                </ul>
            </li>
            <li>Das Passwort und die Bestätigung müssen exakt übereinstimmen.</li>
        </ul>

        <div style="width:600px">

            <form method="post" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>">

                <ul>

                    <li>
                        <label for="pass_id">Username</label>
                        <input type="text" name="username" id="username" value="" />
                    </li>

                    <li>
                        <label for="text_id">E-Mail</label>
                        <input type="text" name="email" id="email" value="" />
                    </li>

                    <li>
                        <label for="pass_id">Password</label>
                        <input type="password" name="password" id="password" value="" />
                    </li>

                    <li>
                        <label for="text_id">Confirm Password</label>
                        <input type="password" name="confirmpwd" id="confirmpwd" value="" />
                    </li>

                    <li>
                        <input type="button" value="Register" onclick="return regformhash(this.form,
                                        this.form.username,
                                        this.form.email,
                                        this.form.password,
                                        this.form.confirmpwd);" />
                    </li>

                </ul>

            </form>

        </div>

        <p>Return to the <a href="index.php?cp">main page</a>.</p>
    </body>
</html>