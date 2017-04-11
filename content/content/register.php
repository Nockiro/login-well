<?php
include_once 'core/register.inc.php';
?>
<!-- Anmeldeformular für die Ausgabe, wenn die POST-Variablen nicht gesetzt sind
oder wenn das Anmelde-Skript einen Fehler verursacht hat. -->
<?php
if (!empty($error_msg)) {
    echo $error_msg;
}
?>
<div class="content">
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
        <li>Der Mailversand zu Anbietern der United Internet (web.de, gmx.de) funktioniert derzeit nicht.</li>
    </ul>
</div>
<div class="content">

    <form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">

        <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="" />
        </div>

        <div>
            <label for="email">E-Mail</label>
            <input type="text" name="email" id="email" value="" />
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value="" />
        </div>

        <div>
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirmpwd" value="" />
        </div>

        <div>
            <input type="button" value="Register" onclick="return regformhash(this.form,
                            this.form.username,
                            this.form.email,
                            this.form.password,
                            this.form.confirm_password);" />
        </div>

        </ul>

    </form>

</div>

<div class="content">
    <p style="font-size: large">Return to the <a href="index.php?cp">main page</a>.</p>
</div>