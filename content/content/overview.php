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

<?php if (login_check($mysqli)) : ?>
    <p>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</p>
    <p>Last Logout-Picture: <img src="account/getCard.php?img=<?php echo ($lastcard != -1 ? $lastcard : "nocard"); ?>" width="76" height="105"> </p>
    <p>Would you like to <a href="logout.php">logout</a>?</p>
<?php else : ?>
    <div class="content">
        <form method="post" action="account/process_login.php" name = "login_form">
            <table>
                <td>
                    <label for="pass_id">E-Mail</label>
                    <input type="text" name="email" id="email" value="" /></td>
                <td>
                    <label for="pass_id">Password</label>
                    <input type="password" name="password" id="password" value="" /></td>
                <td>
                    <input type="button" onclick="formhash(this.form, this.form.password);" value="Login" /></td>
            </table>
        </form>

    </div>

    <div class="content">
        <p>If you don't have a login, please <a href=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?cp=register">register</a>.</p>
        <p style="font-size: larger;">There <?php echo ($usercount > 1 ? "are" : "is") ?> currently <?php echo $usercount . ($usercount > 1 ? " Users" : " User"); ?> registered.</p>	
    </div>
<?php endif; ?>