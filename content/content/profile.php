<?php
/* includes the script which takes care of the submitted form */
include_once 'core/account_change.inc.php';
?>

<style type="text/css">
    table {
        text-align: left;
    }
    /* all inputs which are _not_ buttons: Minimum 50% width */
    input {
        min-width: 40%;
    }
    form {
        display: inherit;
    }
</style>
<div class="content">

    <h3>Profil</h3>
    <hr/>
    <form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
        <table>
            <tr>
                <td style="width: 20%">
                    <label for="uid">User-ID:</label>
                </td>
                <td>
                    <div name="uid"><b><?php echo $_SESSION['user_id']; ?></b></div>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="username">Username:</label>
                </td>
                <td>
                    <input name="username" value="<?php echo $_SESSION['username']; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="password">Passwort:</label>
                </td>
                <td>
                    <input name="password" type="password" placeholder="(Zur Änderung ausfüllen)">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="confirm_password">Passwort wiederholen:</label>
                </td>
                <td>
                    <input name="confirm_password" type="password" placeholder="(Zur Änderung ausfüllen)">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="mail">Email:</label>
                </td>
                <td>
                    <input name="mail" type="email" value="<?php echo $_SESSION['USERemail']; ?>" >
                </td>
            </tr>
            <tr>
                <td>
                    <label for="registered">Registriert:</label>
                </td>
                <td>
                    <div name="registered"><?php echo date('d.m.Y H:i:s', strtotime($_SESSION['USERregdate'])); ?></div>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="role">Rolle:</label>
                </td>
                <td>
                    <div name="role">Du bist aktuell <b><?php echo language::GetRoleTitle($_SESSION['USERrole']) ?></b> dieser Seite.</div>
                </td>
            </tr>
        </table>
        <br/>
        <input type="submit" value="&Auml;nderungen &uuml;bernehmen" onclick="return regformhash(this.form,
                            this.form.username,
                            this.form.mail,
                            this.form.password,
                            this.form.confirm_password);"  />

    </form>
    <a href="/index.php?cp=account_deletion">
        <input type="button" value="Account l&ouml;schen" />
    </a>
</div>