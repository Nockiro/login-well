<style type="text/css">
    table {
        text-align: left;
    }
    td {
        width: 30%;
    }
</style>
<div class="content">

    <h3>Profil</h3>
    <hr/>
    <table>
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
                <input name="password" type="password" value="somepass">
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
    <input type="button" value="&Auml;nderungen &uuml;bernehmen" />
    <a href="/index.php?cp=account_deletion">
        <input type="button" value="Account l&ouml;schen" />
    </a>
</div>